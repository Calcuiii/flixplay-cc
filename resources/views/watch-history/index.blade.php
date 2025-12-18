@extends('layouts.app')

@section('title', 'Riwayat Ditonton')

@section('content')
<div style="max-width: 1200px; margin: 100px auto; padding: 40px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin: 0;">📺 Riwayat Ditonton</h1>
        
        <form action="{{ route('watch-history.clear') }}" method="POST" onsubmit="return confirm('Hapus semua riwayat? Tidak bisa dibatalkan!');">
            @csrf
            <button type="submit" style="padding: 10px 20px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; border: none; border-radius: 20px; font-weight: bold; cursor: pointer; transition: all 0.3s;">
                🗑️ Hapus Semua
            </button>
        </form>
    </div>

    @if (session('success'))
        <div style="background: rgba(0, 212, 212, 0.2); border-left: 4px solid #00d4d4; padding: 15px; margin-bottom: 20px; border-radius: 4px; color: #00d4d4;">
            {{ session('success') }}
        </div>
    @endif

    @if ($watchHistory->count() > 0)
        <!-- Watch History List -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-bottom: 50px;">
            @foreach($watchHistory as $history)
                <div style="background: linear-gradient(135deg, #1a1a3e, #0f1a2e); border-radius: 12px; overflow: hidden; position: relative; height: 300px; border: 1px solid rgba(233, 75, 60, 0.2); transition: all 0.3s;">
                    
                    <!-- Film Poster -->
                    <img src="{{ asset($history->film->poster_url) }}" alt="{{ $history->film->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    
                    <!-- Overlay -->
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(10, 14, 39, 0.95), transparent); padding: 15px; transform: translateY(100%); transition: transform 0.3s;" class="movie-overlay">
                        <div style="background: linear-gradient(90deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-size: 14px; font-weight: bold; margin-bottom: 8px;">
                            {{ $history->film->title }}
                        </div>
                        <div style="color: #e5e5e5; font-size: 12px; margin-bottom: 10px;">
                            ⭐ {{ number_format($history->film->rating, 1) }}/10
                        </div>
                        <div style="color: #b0b0b0; font-size: 11px;">
                            Ditonton: {{ $history->last_watched_at->format('d M Y H:i') }} 
                        </div>
                    </div>
                    
                    <!-- Link ke detail -->
                    <a href="{{ route('films.show', $history->film) }}" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1;"></a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
            {{ $watchHistory->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div style="text-align: center; padding: 60px 20px; background: linear-gradient(135deg, rgba(233, 75, 60, 0.1), rgba(0, 212, 212, 0.1)); border-radius: 12px;">
            <div style="font-size: 80px; margin-bottom: 20px;">📭</div>
            <h2 style="color: #b0b0b0; margin-bottom: 15px;">Belum Ada Riwayat Ditonton</h2>
            <p style="color: #888; margin-bottom: 30px;">Mulai menonton film untuk melihat riwayat di sini</p>
            <a href="{{ route('home') }}" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 25px; font-weight: bold;">
                Jelajahi Film
            </a>
        </div>
    @endif
</div>

<style>
    .movie-overlay:hover {
        transform: translateY(0) !important;
    }
    
    div[style*="height: 300px"]:hover img {
        opacity: 0.7;
    }
</style>
@endsection