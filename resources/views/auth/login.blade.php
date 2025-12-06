@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div style="max-width: 500px; margin: 100px auto; padding: 40px; background: linear-gradient(135deg, #1a1a3e, #0f1a2e); border-radius: 12px; border: 1px solid rgba(233, 75, 60, 0.2);">
    
    <h2 style="text-align: center; background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 30px;">Login ke Akun Anda</h2>

    @if ($errors->any())
        <div style="background: rgba(233, 75, 60, 0.2); border-left: 4px solid #e94b3c; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
            @foreach ($errors->all() as $error)
                <p style="color: #ff6b6b; margin: 5px 0;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf

        <div>
            <label for="email" style="display: block; margin-bottom: 8px; font-weight: bold;">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 12px; background: rgba(0, 212, 212, 0.1); border: 1px solid #00d4d4; border-radius: 6px; color: #e5e5e5;">
        </div>

        <div>
            <label for="password" style="display: block; margin-bottom: 8px; font-weight: bold;">Password</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 12px; background: rgba(0, 212, 212, 0.1); border: 1px solid #00d4d4; border-radius: 6px; color: #e5e5e5;">
        </div>

        <div style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" style="margin: 0;">Ingat saya</label>
        </div>

        <button type="submit" style="padding: 12px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: all 0.3s;">
            Login
        </button>
    </form>

    <p style="text-align: center; margin-top: 20px; color: #b0b0b0;">
        Belum punya akun? <a href="{{ route('register') }}" style="color: #00d4d4; text-decoration: none; font-weight: bold;">Daftar di sini</a>
    </p>
</div>
@endsection