@extends('layouts.app')
@section('title', $film->title)
@section('content')

<section style="padding: 100px 50px 50px; max-width: 1200px; margin: 0 auto;">
    
    @if(session('error'))
        <div style="background: rgba(233, 75, 60, 0.2); color: #e94b3c; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #e94b3c;">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div style="background: rgba(76, 175, 80, 0.2); color: #4CAF50; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #4CAF50;">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px;">
        <!-- POSTER -->
        <div>
            <img src="{{ asset($film->poster_url) }}" alt="{{ $film->title }}" 
                 style="width: 100%; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
        </div>

        <!-- INFO -->
        <div>
            <h1 style="font-size: 42px; margin-bottom: 15px; color: #fff;">{{ $film->title }}</h1>
            
            <div style="display: flex; gap: 20px; margin-bottom: 20px; color: #b0b0b0; font-size: 15px;">
                <span>⭐ {{ number_format($film->rating, 1) }}/10</span>
                <span>🎬 {{ $film->genre->name }}</span>
                <span>📅 {{ $film->release_year }}</span>
                <span>⏱️ {{ $film->duration }} min</span>
            </div>

            <p style="font-size: 16px; line-height: 1.8; color: #b0b0b0; margin-bottom: 30px;">
                {{ $film->description }}
            </p>

            <!-- TOMBOL TONTON -->
            <div style="display: flex; gap: 15px; margin-bottom: 30px;">
                @auth
                    @if($canWatch)
                        <!-- User bisa menonton -->
                        <form action="{{ route('films.watch', $film) }}" method="POST">
                            @csrf
                            <button type="submit" style="padding: 15px 40px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; border: none; border-radius: 25px; font-size: 18px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                                <i class="bi bi-play-fill" style="font-size: 24px;"></i> Tonton Sekarang
                            </button>
                        </form>
                    @else
                        <!-- User sudah pernah menonton -->
                        <div style="padding: 15px 30px; background: rgba(233, 75, 60, 0.2); color: #e94b3c; border: 2px solid #e94b3c; border-radius: 25px; font-size: 16px; display: flex; align-items: center; gap: 10px;">
                            <i class="bi bi-lock-fill"></i> Sudah Ditonton - Berlangganan untuk Nonton Ulang
                        </div>
                        <a href="{{ route('subscription.plans') }}" style="padding: 15px 30px; background: linear-gradient(135deg, #00d4d4, #00a8a8); color: white; text-decoration: none; border-radius: 25px; font-size: 16px; font-weight: bold; display: inline-flex; align-items: center; gap: 10px;">
                            <i class="bi bi-star-fill"></i> Lihat Paket Langganan
                        </a>
                    @endif
                @else
                    <!-- User belum login -->
                    <a href="{{ route('login') }}" style="padding: 15px 40px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 25px; font-size: 18px; font-weight: bold; display: inline-flex; align-items: center; gap: 10px;">
                        <i class="bi bi-play-fill" style="font-size: 24px;"></i> Login untuk Menonton
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

@endsection