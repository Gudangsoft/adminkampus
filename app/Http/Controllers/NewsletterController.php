<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;
use App\Models\Newsletter;
use App\Jobs\SendNewsletterJob;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'name' => 'nullable|string|max:255',
            'interests' => 'nullable|array',
            'interests.*' => 'string|in:news,announcements,events,academic'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email sudah terdaftar atau tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $token = Str::random(60);
        
        $subscriber = NewsletterSubscriber::create([
            'email' => $request->email,
            'name' => $request->name,
            'interests' => $request->interests ?? [],
            'verification_token' => $token,
            'status' => 'pending',
            'subscribed_at' => now()
        ]);

        // Send verification email
        $this->sendVerificationEmail($subscriber);

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih! Silakan cek email Anda untuk verifikasi.'
        ]);
    }

    public function verify($token)
    {
        $subscriber = NewsletterSubscriber::where('verification_token', $token)
            ->where('status', 'pending')
            ->first();

        if (!$subscriber) {
            return redirect()->route('home')->with('error', 'Link verifikasi tidak valid atau sudah kadaluarsa.');
        }

        $subscriber->update([
            'status' => 'active',
            'verified_at' => now(),
            'verification_token' => null
        ]);

        return redirect()->route('home')->with('success', 'Email Anda berhasil diverifikasi! Terima kasih telah berlangganan newsletter kami.');
    }

    public function unsubscribe($token)
    {
        $subscriber = NewsletterSubscriber::where('unsubscribe_token', $token)->first();

        if (!$subscriber) {
            return redirect()->route('home')->with('error', 'Link unsubscribe tidak valid.');
        }

        $subscriber->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now()
        ]);

        return view('newsletter.unsubscribed', compact('subscriber'));
    }

    private function sendVerificationEmail($subscriber)
    {
        $verificationUrl = route('newsletter.verify', $subscriber->verification_token);
        
        // Implementation to send verification email
        // You can use Laravel Mail here
    }
}

// Newsletter Admin Controller
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\NewsletterSubscriber;
use App\Jobs\SendNewsletterJob;
use Illuminate\Http\Request;

class NewsletterAdminController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::orderBy('created_at', 'desc')->paginate(20);
        $subscriberCount = NewsletterSubscriber::where('status', 'active')->count();
        
        return view('admin.newsletter.index', compact('newsletters', 'subscriberCount'));
    }

    public function create()
    {
        return view('admin.newsletter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'template' => 'required|in:default,announcement,news',
            'send_immediately' => 'boolean',
            'scheduled_at' => 'nullable|date|after:now'
        ]);

        $newsletter = Newsletter::create([
            'subject' => $request->subject,
            'content' => $request->content,
            'template' => $request->template,
            'status' => $request->send_immediately ? 'sent' : 'draft',
            'scheduled_at' => $request->scheduled_at,
            'created_by' => auth()->id()
        ]);

        if ($request->send_immediately) {
            $this->sendNewsletter($newsletter);
        }

        return redirect()->route('admin.newsletter.index')
            ->with('success', 'Newsletter berhasil ' . ($request->send_immediately ? 'dikirim' : 'disimpan'));
    }

    public function send(Newsletter $newsletter)
    {
        if ($newsletter->status === 'sent') {
            return back()->with('error', 'Newsletter sudah pernah dikirim');
        }

        $this->sendNewsletter($newsletter);
        
        $newsletter->update([
            'status' => 'sent',
            'sent_at' => now()
        ]);

        return back()->with('success', 'Newsletter berhasil dikirim');
    }

    private function sendNewsletter(Newsletter $newsletter)
    {
        $subscribers = NewsletterSubscriber::where('status', 'active')->get();
        
        foreach ($subscribers as $subscriber) {
            SendNewsletterJob::dispatch($newsletter, $subscriber);
        }
    }

    public function subscribers()
    {
        $subscribers = NewsletterSubscriber::orderBy('created_at', 'desc')->paginate(50);
        
        $stats = [
            'total' => NewsletterSubscriber::count(),
            'active' => NewsletterSubscriber::where('status', 'active')->count(),
            'pending' => NewsletterSubscriber::where('status', 'pending')->count(),
            'unsubscribed' => NewsletterSubscriber::where('status', 'unsubscribed')->count()
        ];
        
        return view('admin.newsletter.subscribers', compact('subscribers', 'stats'));
    }
}
