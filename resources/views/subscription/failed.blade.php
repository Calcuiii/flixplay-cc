@extends('layouts.app')

@section('title', 'Pembayaran Gagal')

@section('content')
<div style="max-width: 600px; margin: 150px auto; padding: 40px; text-align: center;">
    
    <div style="font-size: 80px; margin-bottom: 20px;">❌</div>

    <h1 style="color: #e94b3c; margin-bottom: 15px;">Pembayaran Gagal</h1>

    <p style="color: #b0b0b0; font-size: 18px; margin-bottom: 30px;">
        Terjadi kesalahan saat memproses pembayaran Anda. Silakan coba lagi.
    </p>

    <a href="{{ route('subscription.plans') }}" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; transition: all 0.3s;">
        Coba Lagi
    </a>
</div>
@endsection