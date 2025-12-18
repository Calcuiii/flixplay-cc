@extends('layouts.app')

@section('title', 'Pilih Paket Subscription')

@section('content')
<div style="max-width: 1200px; margin: 100px auto; padding: 40px;">
    
    <h1 style="text-align: center; background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 50px;">Pilih Paket Subscription Anda</h1>

    @if (session('error'))
        <div style="background: rgba(233, 75, 60, 0.2); border-left: 4px solid #e94b3c; padding: 15px; margin-bottom: 20px; border-radius: 4px; color: #e94b3c;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
        @foreach($plans as $plan)
            <div style="background: linear-gradient(135deg, #1a1a3e, #0f1a2e); border-radius: 12px; padding: 30px; border: 2px solid rgba(233, 75, 60, 0.2); transition: all 0.3s; position: relative;">
                
                <!-- Plan Name -->
                <h2 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 10px; font-size: 24px;">{{ $plan->name }}</h2>

                <!-- Description -->
                <p style="color: #b0b0b0; margin-bottom: 20px; font-size: 14px;">{{ $plan->description }}</p>

                <!-- Price -->
                <div style="margin-bottom: 20px;">
                    <p style="font-size: 36px; color: #00d4d4; font-weight: bold;">Rp {{ number_format($plan->price, 0, ',', '.') }}</p>
                    <p style="color: #b0b0b0; font-size: 14px;">per {{ $plan->duration_days }} hari</p>
                </div>

                <!-- Features -->
                <ul style="list-style: none; margin-bottom: 30px; padding: 0;">
                    @foreach(json_decode($plan->features, true) as $feature)
                        <li style="color: #e5e5e5; padding: 8px 0; border-bottom: 1px solid rgba(233, 75, 60, 0.1); font-size: 14px;">
                            ✅ {{ $feature }}
                        </li>
                    @endforeach
                </ul>

                <!-- Button -->
                <a href="{{ route('subscription.checkout', $plan) }}" style="display: block; text-align: center; padding: 12px 30px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; transition: all 0.3s; box-shadow: 0 0 20px rgba(233, 75, 60, 0.4);">
                    Pilih Paket Ini
                </a>
            </div>
        @endforeach
    </div>

    <!-- Info Box -->
    <div style="margin-top: 50px; background: linear-gradient(135deg, rgba(0, 212, 212, 0.1), rgba(233, 75, 60, 0.1)); border-left: 4px solid #00d4d4; padding: 20px; border-radius: 4px;">
       <p style="color: #00d4d4; margin: 0;">💡 <strong>Tip:</strong> Setelah subscribe, Anda bisa menonton film unlimited sesuai dengan paket yang dipilih. Langganan akan berlaku selama 30 hari dari tanggal pembayaran.</p>
    </div>
</div>
@endsection