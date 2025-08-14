<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        $sessionId = $request->input('session_id', $this->generateSessionId());
        
        // Log the conversation
        $this->logMessage($sessionId, 'user', $message);
        
        // Generate response
        $response = $this->generateResponse($message);
        
        // Log bot response
        $this->logMessage($sessionId, 'bot', $response['message']);
        
        return response()->json([
            'session_id' => $sessionId,
            'message' => $response['message'],
            'type' => $response['type'],
            'suggestions' => $response['suggestions'] ?? [],
            'faqs' => $response['faqs'] ?? []
        ]);
    }

    private function generateResponse($message)
    {
        $message = strtolower(trim($message));
        
        // Greeting responses
        if ($this->isGreeting($message)) {
            return [
                'type' => 'greeting',
                'message' => 'Halo! 👋 Saya adalah asisten virtual kampus. Saya siap membantu Anda dengan informasi seputar kampus. Apa yang ingin Anda ketahui?',
                'suggestions' => [
                    'Informasi pendaftaran',
                    'Jadwal kuliah',
                    'Fasilitas kampus',
                    'Kontak admin'
                ]
            ];
        }

        // FAQ Search
        $matchingFaqs = FAQ::searchByQuestion($message);
        if ($matchingFaqs->count() > 0) {
            $faq = $matchingFaqs->first();
            $faq->incrementViews();
            
            return [
                'type' => 'faq_answer',
                'message' => $faq->answer,
                'faqs' => $matchingFaqs->take(3)->map(function($faq) {
                    return [
                        'id' => $faq->id,
                        'question' => $faq->question,
                        'answer' => Str::limit($faq->answer, 100)
                    ];
                })
            ];
        }

        // Specific topic responses
        $responses = $this->getTopicResponses();
        foreach ($responses as $keywords => $response) {
            if ($this->containsKeywords($message, explode('|', $keywords))) {
                return $response;
            }
        }

        // Default response with suggestions
        return [
            'type' => 'default',
            'message' => 'Maaf, saya belum memahami pertanyaan Anda. Mungkin saya bisa membantu dengan topik-topik berikut:',
            'suggestions' => [
                'Cara mendaftar kuliah',
                'Biaya pendidikan',
                'Fasilitas kampus',
                'Program studi yang tersedia',
                'Kontak kampus'
            ]
        ];
    }

    private function isGreeting($message)
    {
        $greetings = ['halo', 'hai', 'hello', 'hi', 'selamat', 'good'];
        return $this->containsKeywords($message, $greetings);
    }

    private function containsKeywords($message, $keywords)
    {
        foreach ($keywords as $keyword) {
            if (strpos($message, strtolower($keyword)) !== false) {
                return true;
            }
        }
        return false;
    }

    private function getTopicResponses()
    {
        return [
            'pendaftaran|daftar|registrasi' => [
                'type' => 'info',
                'message' => 'Untuk informasi pendaftaran, Anda bisa mengunjungi halaman pendaftaran kami atau menghubungi bagian admisi. Pendaftaran dibuka setiap semester dengan berbagai program studi yang tersedia.',
                'suggestions' => [
                    'Syarat pendaftaran',
                    'Biaya pendidikan',
                    'Jadwal pendaftaran',
                    'Program studi'
                ]
            ],
            'biaya|bayar|spp|uang kuliah' => [
                'type' => 'info', 
                'message' => 'Informasi lengkap mengenai biaya pendidikan dapat Anda lihat di halaman informasi biaya atau menghubungi bagian keuangan kampus.',
                'suggestions' => [
                    'Cara pembayaran',
                    'Beasiswa',
                    'Cicilan',
                    'Kontak keuangan'
                ]
            ],
            'fasilitas|gedung|laboratorium|perpustakaan' => [
                'type' => 'info',
                'message' => 'Kampus kami memiliki fasilitas lengkap termasuk perpustakaan modern, laboratorium, ruang kelas ber-AC, dan fasilitas olahraga. Anda bisa melihat virtual tour di website kami.',
                'suggestions' => [
                    'Virtual tour',
                    'Perpustakaan',
                    'Laboratorium',
                    'Fasilitas olahraga'
                ]
            ],
            'kontak|telepon|email|alamat' => [
                'type' => 'contact',
                'message' => 'Anda bisa menghubungi kami melalui:\n📞 Telepon: (021) 1234-5678\n📧 Email: info@kampus.ac.id\n📍 Alamat: Jl. Kampus No. 123, Jakarta',
                'suggestions' => [
                    'Jam operasional',
                    'Lokasi kampus',
                    'Media sosial',
                    'Chat WhatsApp'
                ]
            ]
        ];
    }

    private function generateSessionId()
    {
        return 'chat_' . Str::random(10) . '_' . time();
    }

    private function logMessage($sessionId, $sender, $message)
    {
        try {
            $session = DB::table('chat_sessions')->where('session_id', $sessionId)->first();
            
            $newMessage = [
                'sender' => $sender,
                'message' => $message,
                'timestamp' => now()->toISOString()
            ];

            if ($session) {
                $messages = json_decode($session->messages, true) ?? [];
                $messages[] = $newMessage;
                
                DB::table('chat_sessions')
                    ->where('session_id', $sessionId)
                    ->update([
                        'messages' => json_encode($messages),
                        'last_activity' => now()
                    ]);
            } else {
                DB::table('chat_sessions')->insert([
                    'session_id' => $sessionId,
                    'user_ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'messages' => json_encode([$newMessage]),
                    'last_activity' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        } catch (\Exception $e) {
            // Silent fail - don't break chat if logging fails
            \Log::error('Chat logging failed: ' . $e->getMessage());
        }
    }

    public function getFaqs(Request $request)
    {
        $category = $request->get('category', 'all');
        
        $query = FAQ::active()->ordered();
        
        if ($category !== 'all') {
            $query->byCategory($category);
        }
        
        $faqs = $query->get()->groupBy('category');
        $categories = FAQ::getCategories();
        
        return response()->json([
            'faqs' => $faqs,
            'categories' => $categories
        ]);
    }

    public function getFaqById($id)
    {
        $faq = FAQ::active()->find($id);
        
        if (!$faq) {
            return response()->json(['error' => 'FAQ not found'], 404);
        }
        
        $faq->incrementViews();
        
        return response()->json([
            'faq' => $faq,
            'related' => FAQ::active()
                ->byCategory($faq->category)
                ->where('id', '!=', $faq->id)
                ->take(3)
                ->get()
        ]);
    }
}
