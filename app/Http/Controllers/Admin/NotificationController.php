<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function index()
    {
        // Get notification statistics
        $totalSubscribers = PushSubscription::count();
        $sentToday = Notification::whereDate('created_at', today())->count();
        $sentThisWeek = Notification::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();
        $sentThisMonth = Notification::whereMonth('created_at', now()->month)
                                   ->whereYear('created_at', now()->year)
                                   ->count();

        // Get recent notifications with pagination
        $notifications = Notification::latest()
                                   ->paginate(15);

        return view('admin.notifications.index', compact(
            'totalSubscribers',
            'sentToday', 
            'sentThisWeek',
            'sentThisMonth',
            'notifications'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'message' => 'required|string|max:500',
            'type' => 'required|in:info,success,warning,urgent',
            'icon' => 'nullable|url',
            'url' => 'nullable|url',
            'badge' => 'nullable|url',
            'send_to' => 'required|in:all,test'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create notification record
            $notification = Notification::create([
                'title' => $request->title,
                'message' => $request->message,
                'type' => $request->type,
                'icon' => $request->icon,
                'url' => $request->url,
                'badge' => $request->badge,
                'status' => 'pending'
            ]);

            // Get subscriptions based on send_to parameter
            if ($request->send_to === 'test') {
                // Send only to admin users (you might need to adjust this logic)
                $subscriptions = PushSubscription::whereHas('user', function($query) {
                    $query->where('role', 'admin');
                })->get();
            } else {
                $subscriptions = PushSubscription::all();
            }

            if ($subscriptions->isEmpty()) {
                $notification->update(['status' => 'failed']);
                return response()->json([
                    'success' => false,
                    'message' => 'No subscribers found'
                ]);
            }

            // Send notification to subscribers
            $sentCount = $this->sendNotification($notification, $subscriptions);
            
            // Update notification status
            $notification->update([
                'status' => $sentCount > 0 ? 'sent' : 'failed',
                'recipients_count' => $sentCount
            ]);

            return response()->json([
                'success' => true,
                'message' => "Notification sent to {$sentCount} subscribers"
            ]);

        } catch (\Exception $e) {
            \Log::error('Notification send error: ' . $e->getMessage());
            
            if (isset($notification)) {
                $notification->update(['status' => 'failed']);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send notification: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'notification' => $notification
        ]);
    }

    public function destroy($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete notification'
            ], 500);
        }
    }

    public function resend($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            
            if ($notification->status !== 'failed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only failed notifications can be resent'
                ]);
            }

            // Get all subscriptions
            $subscriptions = PushSubscription::all();
            
            if ($subscriptions->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No subscribers found'
                ]);
            }

            // Resend notification
            $sentCount = $this->sendNotification($notification, $subscriptions);
            
            // Update notification status
            $notification->update([
                'status' => $sentCount > 0 ? 'sent' : 'failed',
                'recipients_count' => $sentCount
            ]);

            return response()->json([
                'success' => true,
                'message' => "Notification resent to {$sentCount} subscribers"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend notification: ' . $e->getMessage()
            ], 500);
        }
    }

    public function send(Request $request)
    {
        return $this->store($request);
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endpoint' => 'required|url',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid subscription data',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create or update subscription
            $subscription = PushSubscription::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'endpoint' => $request->endpoint
                ],
                [
                    'p256dh_key' => $request->keys['p256dh'],
                    'auth_key' => $request->keys['auth']
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Subscription saved successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Push subscription error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save subscription'
            ], 500);
        }
    }

    public function unsubscribe(Request $request)
    {
        try {
            $subscription = PushSubscription::where('user_id', auth()->id())
                                           ->where('endpoint', $request->endpoint)
                                           ->first();

            if ($subscription) {
                $subscription->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Unsubscribed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to unsubscribe'
            ], 500);
        }
    }

    public function export()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        
        $filename = 'notification_history_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($notifications) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Title', 'Message', 'Type', 'Recipients', 
                'Status', 'Sent At', 'URL', 'Icon', 'Badge'
            ]);
            
            // CSV data
            foreach ($notifications as $notification) {
                fputcsv($file, [
                    $notification->id,
                    $notification->title,
                    $notification->message,
                    $notification->type,
                    $notification->recipients_count ?? 'All',
                    $notification->status,
                    $notification->created_at->format('Y-m-d H:i:s'),
                    $notification->url ?? '',
                    $notification->icon ?? '',
                    $notification->badge ?? ''
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function sendNotification($notification, $subscriptions)
    {
        $sentCount = 0;
        
        foreach ($subscriptions as $subscription) {
            try {
                // Here you would implement the actual push notification sending
                // For now, we'll just simulate success
                // In a real implementation, you'd use a library like web-push-php
                
                $sentCount++;
                
            } catch (\Exception $e) {
                \Log::error('Failed to send push notification: ' . $e->getMessage());
                continue;
            }
        }
        
        return $sentCount;
    }
}
