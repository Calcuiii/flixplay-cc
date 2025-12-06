@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- ============ HERO SECTION ============ -->
<section class="hero" id="home">
    <video autoplay muted loop>
        <source src="{{ asset('videos/trailer.mp4') }}" type="video/mp4">
        Browser Anda tidak mendukung video HTML5
    </video>
    
    <div class="hero-content">
        @if($featuredFilms->first())
            <h1>{{ $featuredFilms->first()->title }}</h1>
            <p>{{ Str::limit($featuredFilms->first()->description, 250) }}</p>
        @else
            <h1>Sore : Istri dari Masa Depan</h1>
            <p>Film Sore: Istri dari Masa Depan menceritakan kisah cinta lintas waktu tentang Sore, seorang wanita dari masa depan, yang datang ke masa lalu untuk mengubah kebiasaan suaminya, Jonathan, agar terhindar dari takdir buruk</p>
        @endif
        <div class="hero-buttons">
            @if($featuredFilms->first())
                <a href="{{ route('films.show', $featuredFilms->first()) }}" class="btn-watch" style="text-decoration: none;">
                    <i class="bi bi-play-fill"></i> Tonton Sekarang
                </a>
            @else
                <button class="btn-watch"><i class="bi bi-play-fill"></i> Tonton Sekarang</button>
            @endif
            <button class="btn-info"><i class="bi bi-info-circle"></i> Informasi Lebih Lanjut</button>
        </div>
    </div>
</section>

<!-- ============ TRENDING SECTION ============ -->
<section class="category-section" id="trending">
    <h2 class="category-title">🔥 TRENDING SEKARANG</h2>
    <div class="movie-container">
        @forelse($trendingFilms as $film)
            <div class="movie-card">
                <img src="{{ asset($film->poster_url) }}" alt="{{ $film->title }}">
                <div class="movie-overlay">
                    <div class="movie-title">{{ $film->title }}</div>
                    <div class="movie-rating">⭐ {{ number_format($film->rating, 1) }}/10</div>
                    <div class="movie-actions">
                        <button class="icon-btn"><i class="bi bi-play-fill"></i></button>
                        <button class="icon-btn"><i class="bi bi-plus"></i></button>
                        <button class="icon-btn"><i class="bi bi-hand-thumbs-up"></i></button>
                    </div>
                </div>
            </div>
        @empty
            <p style="color: #b0b0b0;">Belum ada film trending</p>
        @endforelse
    </div>
</section>

<!-- ============ FEATURED SECTION ============ -->
<section class="featured-section" id="featured">
    <h2 class="featured-title">✨ PILIHAN EDITOR</h2>
    @if($featuredFilms->count() > 1)
        <p class="featured-desc">{{ $featuredFilms[1]->description }}</p>
        <img src="{{ asset($featuredFilms[1]->poster_url) }}" alt="{{ $featuredFilms[1]->title }}" class="featured-img">
    @else
        <p class="featured-desc">The Wind Rises adalah film biografi animasi karya Hayao Miyazaki yang mengikuti kehidupan insinyur pesawat legendaris Jepang, Jiro Horikoshi, dan pengembangan pesawat tempur Mitsubishi A6M "Zero" selama Perang Dunia II. Film ini berfokus pada impian masa kecil Jiro, kesulitan yang dihadapinya karena rabun jauh, dan perannya yang kompleks sebagai pencipta di tengah-tengah perang.</p>
        <img src="{{ asset('images/film7.jpeg') }}" alt="Featured" class="featured-img">
    @endif
</section>

<!-- ============ POPULAR SECTION ============ -->
<section class="category-section" id="movies">
    <h2 class="category-title">⭐ POPULER DI FLIXPLAY</h2>
    <div class="movie-container">
        @forelse($popularFilms as $film)
            <div class="movie-card">
                <img src="{{ asset($film->poster_url) }}" alt="{{ $film->title }}">
                <div class="movie-overlay">
                    <div class="movie-title">{{ $film->title }}</div>
                    <div class="movie-rating">⭐ {{ number_format($film->rating, 1) }}/10</div>
                    <div class="movie-actions">
                        <button class="icon-btn"><i class="bi bi-play-fill"></i></button>
                        <button class="icon-btn"><i class="bi bi-plus"></i></button>
                        <button class="icon-btn"><i class="bi bi-hand-thumbs-up"></i></button>
                    </div>
                </div>
            </div>
        @empty
            <p style="color: #b0b0b0;">Belum ada film populer</p>
        @endforelse
    </div>
</section>
@endsection