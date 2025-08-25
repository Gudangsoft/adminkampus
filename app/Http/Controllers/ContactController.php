<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }
    
    public function store(Request $request)
    {
        // Handle contact form submission
        return back()->with('success', 'Pesan berhasil dikirim!');
    }
    
    public function testEmail()
    {
        return response()->json(['message' => 'Email test endpoint']);
    }
}
