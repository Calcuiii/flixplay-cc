@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- HERO SECTION - AUTO SLIDING IMAGES -->
<section style="position: relative; height: 70vh; min-height: 500px; overflow: hidden; margin-top: 70px;">
    <!-- Slider Container -->
    <div id="heroSlider" style="display: flex; transition: transform 1s ease-in-out; height: 100%; width: 100%;">
        @php
            $heroImages = [
                'images/hero1.jpg',
                'images/hero2.jpg',
                'images/hero3.jpg',
                'images/hero4.jpg',
                'images/hero5.jpg',
            ];
        @endphp
        
        @foreach($heroImages as $index => $image)
            <div style="min-width: 100%; height: 100%; position: relative; flex-shrink: 0;">
                <img src="{{ asset($image) }}" 
                     alt="Hero {{ $index + 1 }}"
                     style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(10, 14, 39, 0.5));"></div>
            </div>
        @endforeach
    </div>
    
    <!-- Slide Indicators (Dots) -->
    <div style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); display: flex; gap: 10px; z-index: 20;">
        @foreach($heroImages as $index => $image)
            <div class="slide-indicator" 
                 data-slide="{{ $index }}" 
                 style="width: 40px; height: 4px; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s; border-radius: 2px;">
            </div>
        @endforeach
    </div>
    
    <!-- Navigation Arrows -->
    <button id="prevSlide" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.6); border: none; color: white; font-size: 30px; padding: 15px 20px; cursor: pointer; border-radius: 50%; z-index: 20; transition: all 0.3s; backdrop-filter: blur(10px);">
        <i class="bi bi-chevron-left"></i>
    </button>
    <button id="nextSlide" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.6); border: none; color: white; font-size: 30px; padding: 15px 20px; cursor: pointer; border-radius: 50%; z-index: 20; transition: all 0.3s; backdrop-filter: blur(10px);">
        <i class="bi bi-chevron-right"></i>
    </button>
</section>

<!-- ✅ SCRIPT HANYA 1 KALI -->
<script>
    let currentSlide = 0;
    const totalSlides = {{ count($heroImages) }};
    const slider = document.getElementById('heroSlider');
    const indicators = document.querySelectorAll('.slide-indicator');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    let autoSlideInterval;
    
    function updateSlider() {
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        indicators.forEach((indicator, index) => {
            if (index === currentSlide) {
                indicator.style.background = '#e94b3c';
                indicator.style.width = '60px';
            } else {
                indicator.style.background = 'rgba(255,255,255,0.5)';
                indicator.style.width = '40px';
            }
        });
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSlider();
    }
    
    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateSlider();
    }
    
    function startAutoSlide() {
        autoSlideInterval = setInterval(nextSlide, 3000);
    }
    
    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }
    
    startAutoSlide();
    
    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);
    
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentSlide = index;
            updateSlider();
            stopAutoSlide();
            startAutoSlide();
        });
    });
    
    nextBtn.addEventListener('click', () => {
        nextSlide();
        stopAutoSlide();
        startAutoSlide();
    });
    
    prevBtn.addEventListener('click', () => {
        prevSlide();
        stopAutoSlide();
        startAutoSlide();
    });
    
    [prevBtn, nextBtn].forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            btn.style.background = 'rgba(233, 75, 60, 0.9)';
            btn.style.transform = 'translateY(-50%) scale(1.1)';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.background = 'rgba(0,0,0,0.6)';
            btn.style.transform = 'translateY(-50%) scale(1)';
        });
    });
    
    updateSlider();
</script>

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
                        <a href="{{ route('films.show', $film) }}" class="icon-btn" style="text-decoration: none;">
                            <i class="bi bi-play-fill"></i>
                        </a>
                        
                        @auth
                            @if(auth()->user()->hasInWatchlist($film->id))
                                <form action="{{ route('watchlist.destroy', $film) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-btn" style="background: linear-gradient(135deg, #4CAF50, #45a049);" title="Hapus dari Watchlist">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                            @else
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
    
    @if($featuredFilms->count() > 0)
        @php $featured = $featuredFilms->first(); @endphp
        
        <p class="featured-desc">{{ $featured->description }}</p>
        <img src="{{ asset($featured->poster_url) }}" 
             alt="{{ $featured->title }}" 
             class="featured-img">
        
        <!-- Optional: Tombol Tonton -->
        <div style="text-align: center; margin-top: 25px;">
            <a href="{{ route('films.show', $featured) }}" 
               style="padding: 15px 40px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 30px; font-weight: bold; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s;"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 30px rgba(233,75,60,0.5)';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="bi bi-play-fill" style="font-size: 20px;"></i> Tonton Sekarang
            </a>
        </div>
    @else
        <!-- Fallback jika belum ada film featured -->
        <p class="featured-desc">Belum ada film yang ditandai sebagai pilihan editor. Admin dapat menandai film di admin panel.</p>
        <div style="text-align: center; padding: 40px 20px;">
            <a href="{{ route('films.index') }}" 
               style="padding: 15px 30px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block;">
                Jelajahi Semua Film
            </a>
        </div>
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
                        <a href="{{ route('films.show', $film) }}" class="icon-btn" style="text-decoration: none;">
                            <i class="bi bi-play-fill"></i>
                        </a>
                        
                        @auth
                            @if(auth()->user()->hasInWatchlist($film->id))
                                <form action="{{ route('watchlist.destroy', $film) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-btn" style="background: linear-gradient(135deg, #4CAF50, #45a049);" title="Hapus dari Watchlist">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                            @else
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