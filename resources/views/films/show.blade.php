@extends('layouts.app')

@section('title', $film->title)

@section('content')
<section style="padding: 50px; margin-top: 20px;">
    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 30px;">
        <!-- Poster -->
        <div>
            <img src="{{ $film->poster_url }}" alt="{{ $film->title }}" style="width: 100%; border-radius: 12px; box-shadow: 0 0 20px rgba(0, 208, 132, 0.3);">
        </div>

        <!-- Details -->
        <div>
            <h1 style="font-size: 36px; background: linear-gradient(135deg, #00d084, #0099ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 15px;">{{ $film->title }}</h1>
            
            <p style="color: #b0b0b0; margin-bottom: 10px;"><strong>Direktur:</strong> {{ $film->director }}</p>
            <p style="color: #b0b0b0; margin-bottom: 10px;"><strong>Tahun:</strong> {{ $film->release_year }}</p>
            <p style="color: #b0b0b0; margin-bottom: 10px;"><strong>Genre:</strong> <a href="{{ route('films.genre', $film->genre) }}" style="color: #00d084;">{{ $film->genre->name }}</a></p>
            <p style="color: #b0b0b0; margin-bottom: 10px;"><strong>Durasi:</strong> {{ $film->duration }} menit</p>
            <p style="color: #b0b0b0; margin-bottom: 20px;"><strong>Rating:</strong> ⭐ {{ $film->rating }}/10</p>

            <p style="color: #e5e5e5; line-height: 1.8; margin-bottom: 30px;">{{ $film->description }}</p>

            <a href="{{ $film->video_url }}" target="_blank" style="padding: 12px 30px; background: linear-gradient(135deg, #00d084, #00b870); color: #fff; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-flex; align-items: center; gap: 8px;">
                <i class="bi bi-play-fill"></i> Tonton Film
            </a>
        </div>
    </div>

    <!-- Related Films -->
    @if($relatedFilms->count() > 0)
    <section style="margin-top: 50px;">
        <h2 class="category-title">Film Serupa</h2>
        <div class="movie-container">
            @foreach($relatedFilms as $related)
            <a href="{{ route('films.show', $related) }}" class="movie-card">
                <img src="{{ $related->poster_url }}" alt="{{ $related->title }}">
            </a>
            @endforeach
        </div>
    </section>
    @endif
</section>
@endsection