@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- HERO SECTION - AUTO SLIDING BACKDROPS -->
<section style="position: relative; height: 70vh; min-height: 500px; overflow: hidden; margin-top: 70px;">
    @if($heroFilms->count() > 0)
        <!-- Slider Container -->
        <div id="heroSlider" style="display: flex; transition: transform 1s ease-in-out; height: 100%; width: 100%;">
            @foreach($heroFilms as $index => $film)
                <div style="min-width: 100%; height: 100%; position: relative; flex-shrink: 0;">
                    <!-- Hero Backdrop Image -->
                    <img src="{{ asset($film->backdrop_url) }}" 
                         alt="{{ $film->title }}"
                         style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                    
                    <!-- Dark Gradient Overlay -->
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to right, rgba(10, 14, 39, 0.9) 30%, transparent 70%);"></div>
                    
                    <!-- Film Info -->
                    <div style="position: absolute; bottom: 80px; left: 50px; max-width: 600px; color: white; z-index: 10;">
                        <div style="background: rgba(233, 75, 60, 0.9); padding: 5px 15px; border-radius: 15px; display: inline-block; margin-bottom: 15px; font-size: 12px; font-weight: bold;">
                            {{ $film->genre->name }}
                        </div>
                        <h1 style="font-size: 48px; margin-bottom: 15px; text-shadow: 2px 2px 8px rgba(0,0,0,0.8);">
                            {{ $film->title }}
                        </h1>
                        <div style="display: flex; gap: 15px; margin-bottom: 20px; font-size: 16px; text-shadow: 1px 1px 4px rgba(0,0,0,0.8);">
                            <span>⭐ {{ number_format($film->rating, 1) }}/10</span>
                            <span>{{ $film->release_year }}</span>
                            <span>{{ $film->duration }} min</span>
                        </div>
                        <p style="font-size: 16px; line-height: 1.6; margin-bottom: 25px; text-shadow: 1px 1px 4px rgba(0,0,0,0.8);">
                            {{ Str::limit($film->description, 150) }}
                        </p>
                        <a href="{{ route('films.show', $film) }}" 
                           style="padding: 15px 35px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s;"
                           onmouseover="this.style.transform='translateY(-3px)';"
                           onmouseout="this.style.transform='translateY(0)';">
                            <i class="bi bi-play-fill" style="font-size: 20px;"></i> Tonton Sekarang
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Slide Indicators -->
        <div style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); display: flex; gap: 10px; z-index: 20;">
            @foreach($heroFilms as $index => $film)
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
    @else
        <!-- Fallback jika belum ada hero films -->
        <div style="height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #0a0e27, #1a1a3e); color: white; text-align: center; padding: 40px;">
            <div>
                <h1 style="font-size: 48px; margin-bottom: 20px;">Selamat Datang di FlixPlay</h1>
                <p style="font-size: 20px; color: #b0b0b0; margin-bottom: 30px;">Platform streaming film terbaik untuk Anda</p>
                <a href="{{ route('films.index') }}" 
                   style="padding: 15px 40px; background: linear-gradient(135deg, #e94b3c, #d63a2a); color: white; text-decoration: none; border-radius: 30px; font-weight: bold; display: inline-block;">
                    Jelajahi Film
                </a>
            </div>
        </div>
    @endif
</section>

<script>
    let currentSlide = 0;
    const totalSlides = {{ $heroFilms->count() }};
    const slider = document.getElementById('heroSlider');
    const indicators = document.querySelectorAll('.slide-indicator');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    let autoSlideInterval;
    
    if (totalSlides > 0) {
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
            autoSlideInterval = setInterval(nextSlide, 5000); // 5 detik
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
    }
</script>

<script>
    let currentSlide = 0;
    const totalSlides = {{ count($heroFilms) }};
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
                    </div>
                </div>
            </div>
        @empty
            <p style="color: #b0b0b0;">Belum ada film populer</p>
        @endforelse
    </div>
</section>

@endsection