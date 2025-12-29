@extends('layouts.app')
@section('title', 'Semua Film')
@section('content')
<section class="category-section" style="margin-top: 90px;">
    <h2 class="category-title">📽️ SEMUA FILM</h2>
    
    @if(session('success'))
        <div style="background: rgba(76, 175, 80, 0.2); color: #4CAF50; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #4CAF50; max-width: 600px;">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div style="background: rgba(33, 150, 243, 0.2); color: #2196F3; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #2196F3; max-width: 600px;">
            <i class="bi bi-info-circle"></i> {{ session('info') }}
        </div>
    @endif

    <div class="movie-container">
        @forelse($films as $film)
            <div class="movie-card">
                <img src="{{ asset($film->poster_url) }}" alt="{{ $film->title }}">
                <div class="movie-overlay">
                    <div class="movie-title">{{ $film->title }}</div>
                    <div class="movie-rating">⭐ {{ number_format($film->rating, 1) }}/10</div>
                    <div style="font-size: 11px; color: #b0b0b0; margin-bottom: 10px;">
                        {{ $film->genre->name }} • {{ $film->release_year }}
                    </div>
                    <div class="movie-actions">
                        <a href="{{ route('films.show', $film) }}" class="icon-btn" style="text-decoration: none;">
                            <i class="bi bi-play-fill"></i>
                        </a>
                        
                        @auth
                            @if(auth()->user()->hasInWatchlist($film->id))
                                <!-- Jika sudah ada di watchlist -->
                                <form action="{{ route('watchlist.destroy', $film) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-btn" style="background: linear-gradient(135deg, #4CAF50, #45a049);" title="Hapus dari Watchlist">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                            @else
                                <!-- Jika belum ada di watchlist -->
                                <form action="{{ route('watchlist.store', $film) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="icon-btn" title="Tambah ke Watchlist">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="icon-btn" title="Login untuk menambah ke Watchlist">
                                <i class="bi bi-plus"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 60px 20px; color: #b0b0b0;">
                <i class="bi bi-film" style="font-size: 64px; display: block; margin-bottom: 20px; opacity: 0.3;"></i>
                <h3 style="font-size: 24px; margin-bottom: 10px; color: #fff;">Belum Ada Film</h3>
                <p style="font-size: 16px;">Film akan segera ditambahkan</p>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if($films->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 40px;">
            {{ $films->links() }}
        </div>
    @endif
</section>
@endsection