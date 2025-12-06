@extends('layouts.app')

@section('title', 'Pembayaran Pending')

@section('content')
<div style="max-width: 600px; margin: 150px auto; padding: 40px; text-align: center;">
    
    <div style="font-size: 80px; margin-bottom: 20px;">⏳</div>

    <h1 style="color: #00d4d4; margin-bottom: 15px;">Pembayaran Sedang Diproses</h1>

    <p style="color: #b0b0b0; font-size: 18px; margin-bottom: 30px;">
        Pembayaran Anda sedang diproses. Silakan tunggu beberapa saat...
    </p>

    <a href="{{ route('dashboard') }}" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #00d4d4, #00a8a8); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; transition: all 0.3s;">
        Kembali ke Dashboard
    </a>
</div>
@endsection