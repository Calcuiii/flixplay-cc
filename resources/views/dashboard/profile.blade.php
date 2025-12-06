@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div style="max-width: 600px; margin: 100px auto; padding: 40px; background: linear-gradient(135deg, #1a1a3e, #0f1a2e); border-radius: 12px; border: 1px solid rgba(233, 75, 60, 0.2);">
    
    <h2 style="text-align: center; background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 30px;">Edit Profil</h2>

    @if (session('success'))
        <div style="background: rgba(0, 212, 212, 0.2); border-left: 4px solid #00d4d4; padding: 15px; margin-bottom: 20px; border-radius: 4px; color: #00d4d4;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: rgba(233, 75, 60, 0.2); border-left: 4px solid #e94b3c; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
            @foreach ($errors->all() as $error)
                <p style="color: #ff6b6b; margin: 5px 0;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf

        <div>
            <label for="name" style="display: block; margin-bottom: 8px; font-weight: bold;">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" required style="width: 100%; padding: 12px; background: rgba(0, 212, 212, 0.1); border: 1px solid #00d4d4; border-radius: 6px; color: #e5e5e5;">
        </div>

        <div>
            <label for="email" style="display: block; margin-bottom: 8px; font-weight: bold;">Email</label>
            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required style="width: 100%; padding: 12px; background: rgba(0, 212, 212, 0.1); border: 1px solid #00d4d4; border-radius: 6px; color: #e5e5e5;">
        </div>

        <div>
            <label for="password" style="display: block; margin-bottom: 8px; font-weight: bold;">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" id="password" name="password" style="width: 100%; padding: 12px; background: rgba(0, 212, 212, 0.1); border: 1px solid #00d4d4; border-radius: 6px; color: #e5e5e5;">
        </div>

        <div>
            <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: bold;">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" style="width: 100%; padding: 12px; background: rgba(0, 212, 212, 0.1); border: 1px solid #00d4d4; border-radius: 6px; color: #e5e5e5;">
        </div>

        <button type="submit" style="padding: 12px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: all 0.3s;">
            Simpan Perubahan
        </button>
    </form>

    <p style="text-align: center; margin-top: 20px;">
        <a href="{{ route('dashboard') }}" style="color: #00d4d4; text-decoration: none;">Kembali ke Dashboard</a>
    </p>
</div>
@endsection