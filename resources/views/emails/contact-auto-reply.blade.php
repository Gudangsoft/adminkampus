@extends('emails.layout', [
    'title' => 'Konfirmasi Pesan Anda - ' . config('app.name'),
    'siteName' => config('app.name'),
    'homeUrl' => url('/')
])

@section('content')
<h2 style="color: #667eea; margin-bottom: 20px;">Terima Kasih, {{ $name }}!</h2>

<p>Kami telah menerima pesan Anda dan akan merespons secepat mungkin, biasanya dalam waktu 1x24 jam pada hari kerja.</p>

<div class="highlight">
    <h3 style="margin-top: 0; color: #856404;">Ringkasan Pesan Anda:</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 8px 0; width: 120px;"><strong>Subjek:</strong></td>
            <td style="padding: 8px 0;">{{ $subject }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0;"><strong>Waktu Kirim:</strong></td>
            <td style="padding: 8px 0;">{{ now()->format('d F Y, H:i') }} WIB</td>
        </tr>
    </table>
    
    <div style="margin-top: 15px;">
        <strong>Isi Pesan:</strong>
        <div style="background: white; padding: 15px; border-radius: 5px; margin-top: 8px; border-left: 3px solid #667eea;">
            {{ Str::limit($original_message, 200) }}
            @if(strlen($original_message) > 200)...@endif
        </div>
    </div>
</div>

<h3 style="color: #495057;">Informasi Kontak Kami:</h3>
<ul>
    <li><strong>Email:</strong> <a href="mailto:{{ config('mail.admin_email', 'admin@example.com') }}" style="color: #667eea;">{{ config('mail.admin_email', 'admin@example.com') }}</a></li>
    <li><strong>Website:</strong> <a href="{{ url('/') }}" style="color: #667eea;">{{ url('/') }}</a></li>
    <li><strong>Jam Operasional:</strong> Senin - Jumat, 08:00 - 17:00 WIB</li>
</ul>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ url('/') }}" class="btn">Kunjungi Website Kami</a>
</div>

<p style="color: #666; font-size: 14px;">
    <strong>Catatan:</strong> Email ini dikirim otomatis sebagai konfirmasi bahwa pesan Anda telah diterima. 
    Mohon jangan membalas email ini karena tidak akan terbaca.
</p>

<p>Terima kasih atas kepercayaan Anda kepada <strong>{{ config('app.name') }}</strong>!</p>

<p>Salam,<br>
<strong>Tim {{ config('app.name') }}</strong></p>
@endsection
