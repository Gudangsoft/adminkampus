<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display the contact form
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission
     */
    public function store(Request $request)
    {
        // Validate the contact form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'message.required' => 'Pesan wajib diisi.',
            'message.max' => 'Pesan maksimal 2000 karakter.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get validated data
        $contactData = $validator->validated();

        try {
            // Send email to admin
            $adminEmail = config('mail.admin_email', 'admin@example.com');
            Mail::to($adminEmail)->send(new ContactFormMail($contactData));

            // Send auto-reply to user (optional)
            if (config('mail.send_contact_reply', true)) {
                $this->sendAutoReply($contactData);
            }

            return back()->with('success', 
                'Terima kasih! Pesan Anda telah dikirim. Kami akan merespons dalam waktu 1x24 jam.');

        } catch (\Exception $e) {
            \Log::error('Contact form email failed: ' . $e->getMessage());
            
            return back()->with('error', 
                'Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.');
        }
    }

    /**
     * Send auto-reply to contact form submitter
     */
    private function sendAutoReply(array $contactData)
    {
        try {
            $autoReplyContent = [
                'name' => $contactData['name'],
                'original_message' => $contactData['message'],
                'subject' => $contactData['subject'] ?? 'Kontak Form',
            ];

            Mail::send('emails.contact-auto-reply', $autoReplyContent, function ($message) use ($contactData) {
                $message->to($contactData['email'], $contactData['name'])
                    ->subject('Terima kasih atas pesan Anda - ' . config('app.name'))
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

        } catch (\Exception $e) {
            \Log::warning('Auto-reply email failed: ' . $e->getMessage());
            // Don't throw exception here to avoid disrupting main flow
        }
    }

    /**
     * Test email functionality (for development)
     */
    public function testEmail()
    {
        if (!app()->environment('local')) {
            abort(404);
        }

        $testData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '08123456789',
            'subject' => 'Test Email',
            'message' => 'Ini adalah pesan test untuk memastikan email berfungsi dengan baik.',
        ];

        try {
            Mail::to('admin@example.com')->send(new ContactFormMail($testData));
            return 'Test email sent successfully!';
        } catch (\Exception $e) {
            return 'Email test failed: ' . $e->getMessage();
        }
    }
}
