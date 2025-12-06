@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div style="max-width: 1200px; margin: 100px auto; padding: 40px;">
    
    <h1 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 10px;">Welcome, {{ auth()->user()->name }}! 👋</h1>
    <p style="color: #b0b0b0; margin-bottom: 30px;">Kelola akun dan langganan Anda di sini</p>

    @if (session('success'))
        <div style="background: rgba(0, 212, 212, 0.2); border-left: 4px solid #00d4d4; padding: 15px; margin-bottom: 20px; border-radius: 4px; color: #00d4d4;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        
        <!-- Profile Card -->
        <div style="background: linear-gradient(135deg, #1a1a3e, #0f1a2e); padding: 25px; border-radius: 12px; border: 1px solid rgba(233, 75, 60, 0.2);">
            <h3 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 15px;">Profil Anda</h3>
            <p style="color: #b0b0b0; margin: 10px 0;">📧 {{ auth()->user()->email }}</p>
            <p style="color: #b0b0b0; margin: 10px 0;">👤 {{ auth()->user()->name }}</p>
            <a href="{{ route('profile') }}" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">Edit Profil</a>
        </div>

        <!-- Subscription Card -->
        <div style="background: linear-gradient(135deg, #1a1a3e, #0f1a2e); padding: 25px; border-radius: 12px; border: 1px solid rgba(233, 75, 60, 0.2);">
            <h3 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 15px;">Status Langganan</h3>
            <p style="color: #b0b0b0; margin: 10px 0;">
                @if(auth()->user()->isSubscribed())
                    💎 {{ ucfirst(auth()->user()->subscription_type) }}
                @else
                    🔓 Gratis
                @endif
            </p>
            <p style="color: #b0b0b0; margin: 10px 0; font-size: 12px;">
                @if(auth()->user()->subscription_expires_at)
                    Berlaku sampai: {{ auth()->user()->subscription_expires_at->format('d M Y') }}
                @else
                    Belum berlangganan
                @endif
            </p>
            <a href="{{ route('subscription.plans') }}" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: linear-gradient(135deg, #00d4d4, #00a8a8); color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">Upgrade Langganan</a>
        </div>

        <!-- Logout Card -->
        <div style="background: linear-gradient(135deg, #1a1a3e, #0f1a2e); padding: 25px; border-radius: 12px; border: 1px solid rgba(233, 75, 60, 0.2);">
            <h3 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 15px;">Akun</h3>
            <p style="color: #b0b0b0; margin: 10px 0;">Keluar dari akun Anda</p>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Logout</button>
            </form>
        </div>
    </div>
</div>
@endsection