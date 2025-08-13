@extends('emails.layout', [
    'title' => 'Berita Terbaru: ' . $news->title,
    'siteName' => config('app.name'),
    'homeUrl' => url('/')
])

@section('content')
<h2 style="color: #667eea; margin-bottom: 20px;">Berita Terbaru dari {{ config('app.name') }}</h2>

<div class="news-meta">
    <h3 style="margin: 0 0 10px 0; color: #495057;">{{ $news->title }}</h3>
    <p style="margin: 5px 0; color: #666; font-size: 14px;">
        <strong>Dipublikasikan:</strong> {{ $news->created_at->format('d F Y, H:i') }} WIB
        @if($news->newsCategory)
        | <strong>Kategori:</strong> {{ $news->newsCategory->name }}
        @endif
    </p>
</div>

@if($news->featured_image)
<div style="text-align: center; margin: 20px 0;">
    <img src="{{ asset('storage/' . $news->featured_image) }}" 
         alt="{{ $news->title }}" 
         style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
</div>
@endif

<div style="margin: 20px 0;">
    @if($news->excerpt)
        <p style="font-size: 16px; color: #495057; font-style: italic; background: #f8f9fa; padding: 15px; border-radius: 5px;">
            {{ $news->excerpt }}
        </p>
    @endif
    
    <div style="color: #333; line-height: 1.7;">
        {!! Str::limit(strip_tags($news->content), 300) !!}
        @if(strlen(strip_tags($news->content)) > 300)
            ...
        @endif
    </div>
</div>

<div class="highlight">
    <p style="margin: 0;">
        <strong>📰 Ingin membaca selengkapnya?</strong><br>
        Klik tombol di bawah untuk membaca artikel lengkap di website kami.
    </p>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ $newsUrl }}" class="btn">Baca Selengkapnya</a>
</div>

<h3 style="color: #495057;">Berita Lainnya yang Mungkin Menarik:</h3>
<p>Jangan lewatkan berita dan pengumuman penting lainnya dari kampus. Kunjungi website kami secara berkala atau berlangganan newsletter untuk mendapatkan update terbaru.</p>

<div style="text-align: center; margin: 20px 0;">
    <a href="{{ url('/news') }}" 
       style="display: inline-block; padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; font-size: 14px;">
        Lihat Semua Berita
    </a>
</div>

<p>Terima kasih telah mengikuti berita dari <strong>{{ config('app.name') }}</strong>!</p>

<p>Salam,<br>
<strong>Tim Redaksi {{ config('app.name') }}</strong></p>
@endsection
