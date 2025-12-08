@extends('layouts.app')
@section('title', 'My Watchlist')
@section('content')

<!-- HEADER -->
<section style="background: linear-gradient(135deg, rgba(233, 75, 60, 0.1), rgba(0, 0, 0, 0.9)); padding: 80px 20px 40px; margin-top: 70px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h1 style="font-size: 48px; margin-bottom: 15px; color: #fff;">
            📋 My Watchlist
        </h1>
        <p style="font-size: 18px; color: #b0b0b0;">
            Film-film yang ingin Anda tonton
        </p>
    </div>
</section>

<!-- NOTIFICATIONS -->
<div style="max-width: 1200px; margin: 20px auto; padding: 0 20px;">
    @if(session('success'))
        <div style="background: rgba(76, 175, 80, 0.2); color: #4CAF50; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #4CAF50;">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div style="background: rgba(33, 150, 243, 0.2); color: #2196F3; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #2196F3;">
            <i class="bi bi-info-circle"></i> {{ session('info') }}
        </div>
    @endif
</div>

<!-- WATCHLIST CONTENT -->
<section style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
    @if($watchlistFilms->count() > 0)
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <p style="color: #b0b0b0; font-size: 16px;">
                {{ $watchlistFilms->count() }} film dalam watchlist Anda
            </p>
            <form action="{{ route('watchlist.clear') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua film dari watchlist?');">
                @csrf
                <button type="submit" style="background: rgba(233, 75, 60, 0.2); color: #e94b3c; border: 1px solid #e94b3c; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-size: 14px; transition: all 0.3s;">
                    <i class="bi bi-trash"></i> Kosongkan Watchlist
                </button>
            </form>
        </div>

        <div class="movie-container">
            @foreach($watchlistFilms as $film)
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
                            <form action="{{ route('watchlist.destroy', $film) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-btn" title="Hapus dari Watchlist">
                                    <i class="bi bi-x"></i>
                                </button>
                            </form>
                            <button class="icon-btn"><i class="bi bi-hand-thumbs-up"></i></button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 80px 20px; color: #b0b0b0;">
            <i class="bi bi-bookmark" style="font-size: 80px; display: block; margin-bottom: 20px; opacity: 0.3;"></i>
            <h2 style="font-size: 28px; margin-bottom: 15px; color: #fff;">Watchlist Kosong</h2>
            <p style="font-size: 16px; margin-bottom: 30px;">
                Anda belum menambahkan film apapun ke watchlist
            </p>
            <a href="{{ route('films.index') }}" style="padding: 15px 30px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block;">
                <i class="bi bi-search"></i> Jelajahi Film
            </a>
        </div>
    @endif
</section>

@endsection