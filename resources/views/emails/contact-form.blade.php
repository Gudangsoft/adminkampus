@extends('emails.layout', [
    'title' => 'Pesan Kontak Baru - ' . config('app.name'),
    'siteName' => config('app.name'),
    'homeUrl' => url('/')
])

@section('content')
<h2 style="color: #667eea; margin-bottom: 20px;">Pesan Kontak Baru</h2>

<p>Ada pesan baru yang masuk melalui formulir kontak website <strong>{{ config('app.name') }}</strong>.</p>

<div class="highlight">
    <h3 style="margin-top: 0; color: #856404;">Detail Pengirim:</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 8px 0; width: 120px;"><strong>Nama:</strong></td>
            <td style="padding: 8px 0;">{{ $contactData['name'] }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0;"><strong>Email:</strong></td>
            <td style="padding: 8px 0;">
                <a href="mailto:{{ $contactData['email'] }}" style="color: #667eea;">
                    {{ $contactData['email'] }}
                </a>
            </td>
        </tr>
        @if(isset($contactData['phone']) && $contactData['phone'])
        <tr>
            <td style="padding: 8px 0;"><strong>Telepon:</strong></td>
            <td style="padding: 8px 0;">{{ $contactData['phone'] }}</td>
        </tr>
        @endif
        @if(isset($contactData['subject']) && $contactData['subject'])
        <tr>
            <td style="padding: 8px 0;"><strong>Subjek:</strong></td>
            <td style="padding: 8px 0;">{{ $contactData['subject'] }}</td>
        </tr>
        @endif
        <tr>
            <td style="padding: 8px 0;"><strong>Waktu:</strong></td>
            <td style="padding: 8px 0;">{{ now()->format('d F Y, H:i') }} WIB</td>
        </tr>
    </table>
</div>

<h3 style="color: #495057;">Isi Pesan:</h3>
<div style="background: #f8f9fa; padding: 20px; border-radius: 5px; border-left: 4px solid #667eea; margin: 15px 0;">
    <p style="margin: 0; white-space: pre-line;">{{ $contactData['message'] }}</p>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="mailto:{{ $contactData['email'] }}?subject=Re: {{ $contactData['subject'] ?? 'Pesan Kontak' }}" 
       class="btn" style="margin-right: 10px;">
        Balas Email
    </a>
    @if(isset($contactData['phone']) && $contactData['phone'])
    <a href="tel:{{ $contactData['phone'] }}" class="btn" 
       style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
        Hubungi via Telepon
    </a>
    @endif
</div>

<p style="color: #666; font-size: 14px;">
    <strong>Catatan:</strong> Email ini dikirim otomatis dari formulir kontak website. 
    Pastikan untuk membalas dalam waktu 1x24 jam untuk memberikan pelayanan terbaik.
</p>
@endsection
