@extends('layouts.app')

@section('title', 'Checkout - ' . $plan->name)

@section('content')
<div style="max-width: 600px; margin: 100px auto; padding: 40px; background: linear-gradient(135deg, #1a1a3e, #0f1a2e); border-radius: 12px; border: 1px solid rgba(233, 75, 60, 0.2);">
    
    <h2 style="text-align: center; background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 30px;">Konfirmasi Checkout</h2>

    <!-- Order Summary -->
    <div style="background: rgba(0, 212, 212, 0.1); border: 1px solid rgba(0, 212, 212, 0.2); padding: 20px; border-radius: 8px; margin-bottom: 30px;">
        
        <h3 style="color: #00d4d4; margin-bottom: 15px;">Ringkasan Pesanan</h3>

        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid rgba(233, 75, 60, 0.2);">
            <p style="color: #b0b0b0;">Paket:</p>
            <p style="color: #e5e5e5; font-weight: bold;">{{ $plan->name }}</p>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid rgba(233, 75, 60, 0.2);">
            <p style="color: #b0b0b0;">Durasi:</p>
            <p style="color: #e5e5e5; font-weight: bold;">{{ $plan->duration_days }} hari</p>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid rgba(233, 75, 60, 0.2);">
            <p style="color: #b0b0b0;">Harga:</p>
            <p style="color: #00d4d4; font-weight: bold; font-size: 18px;">Rp {{ number_format($plan->price, 0, ',', '.') }}</p>
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 2px solid rgba(233, 75, 60, 0.3);">
            <p style="color: #e5e5e5; font-weight: bold;">Total:</p>
            <p style="color: #00d4d4; font-weight: bold; font-size: 20px;">Rp {{ number_format($plan->price, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- User Info -->
    <div style="background: rgba(233, 75, 60, 0.1); border: 1px solid rgba(233, 75, 60, 0.2); padding: 20px; border-radius: 8px; margin-bottom: 30px;">
        
        <h3 style="color: #e94b3c; margin-bottom: 15px;">Data Pembeli</h3>

        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <p style="color: #b0b0b0;">Nama:</p>
            <p style="color: #e5e5e5; font-weight: bold;">{{ $user->name }}</p>
        </div>

        <div style="display: flex; justify-content: space-between;">
            <p style="color: #b0b0b0;">Email:</p>
            <p style="color: #e5e5e5; font-weight: bold;">{{ $user->email }}</p>
        </div>
    </div>

    <!-- Payment Button -->
    <form action="{{ route('payment.process', $plan) }}" method="POST">
        @csrf
        <button type="submit" style="width: 100%; padding: 15px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; border: none; border-radius: 25px; font-weight: bold; font-size: 16px; cursor: pointer; transition: all 0.3s; box-shadow: 0 0 20px rgba(233, 75, 60, 0.4);">
            Lanjutkan ke Pembayaran
        </button>
    </form>

    <!-- Cancel Button -->
    <a href="{{ route('subscription.plans') }}" style="display: block; text-align: center; margin-top: 15px; padding: 12px 30px; background: rgba(0, 212, 212, 0.2); color: #00d4d4; text-decoration: none; border-radius: 25px; font-weight: bold; transition: all 0.3s;">
        Batal
    </a>

    <!-- Info -->
    <div style="margin-top: 20px; padding: 15px; background: rgba(0, 212, 212, 0.1); border-left: 4px solid #00d4d4; border-radius: 4px;">
        <p style="color: #00d4d4; margin: 0; font-size: 13px;">🔒 Pembayaran diproses melalui Midtrans. Data Anda aman dan terenkripsi.</p>
    </div>
</div>
@endsection