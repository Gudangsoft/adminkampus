@extends('emails.layout', [
    'title' => 'Selamat Datang di ' . config('app.name'),
    'siteName' => config('app.name'),
    'homeUrl' => url('/')
])

@section('content')
<h2 style="color: #667eea; margin-bottom: 20px;">Selamat Datang, {{ $user->name }}!</h2>

<p>Terima kasih telah bergabung dengan <strong>{{ config('app.name') }}</strong>. Kami sangat senang memiliki Anda sebagai bagian dari komunitas kampus kami.</p>

<div class="highlight">
    <h3 style="margin-top: 0; color: #856404;">Informasi Akun Anda:</h3>
    <ul style="margin: 10px 0;">
        <li><strong>Nama:</strong> {{ $user->name }}</li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Tanggal Bergabung:</strong> {{ $user->created_at->format('d F Y') }}</li>
    </ul>
</div>

<h3 style="color: #495057;">Apa yang bisa Anda lakukan sekarang?</h3>
<ul>
    <li>Jelajahi <strong>berita terbaru</strong> dan pengumuman kampus</li>
    <li>Lihat <strong>galeri foto</strong> kegiatan kampus</li>
    <li>Akses <strong>informasi fakultas</strong> dan program studi</li>
    <li>Hubungi kami jika ada pertanyaan</li>
</ul>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ url('/') }}" class="btn">Mulai Jelajahi Website</a>
</div>

<p>Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi tim dukungan kami.</p>

<p>Salam hangat,<br>
<strong>Tim {{ config('app.name') }}</strong></p>
@endsection
