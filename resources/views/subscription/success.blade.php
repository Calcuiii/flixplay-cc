@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div style="max-width: 600px; margin: 150px auto; padding: 40px; text-align: center;">
    
    <div style="font-size: 80px; margin-bottom: 20px;">✅</div>

    <h1 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 15px;">Pembayaran Berhasil!</h1>

    <p style="color: #b0b0b0; font-size: 18px; margin-bottom: 30px;">
        Subscription Anda sudah aktif. Nikmati akses unlimited ke semua film di FlixPlay! 🎬
    </p>

    <div style="background: linear-gradient(135deg, rgba(0, 212, 212, 0.1), rgba(233, 75, 60, 0.1)); border: 1px solid rgba(0, 212, 212, 0.2); padding: 25px; border-radius: 8px; margin-bottom: 30px; text-align: left;">
        <h3 style="color: #00d4d4; margin-bottom: 15px;">Informasi Subscription:</h3>
        <p style="color: #b0b0b0; margin: 10px 0;">📅 Status: <strong style="color: #00d4d4;">Aktif</strong></p>
        <p style="color: #b0b0b0; margin: 10px 0;">⏰ Berakhir: <strong style="color: #e5e5e5;">{{ auth()->user()->subscription_expires_at?->format('d M Y') }}</strong></p>
    </div>

    <a href="{{ route('home') }}" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; transition: all 0.3s;">
        Kembali ke Beranda
    </a>
</div>
@endsection