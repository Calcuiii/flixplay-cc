@extends('layouts.app')

@section('title', 'Genre: ' . $genre->name)

@section('content')
<section class="category-section">
    <h2 class="category-title">📽️ {{ $genre->name }}</h2>
    <p style="color: #b0b0b0; margin-bottom: 20px;">{{ $genre->description }}</p>
    
    <div class="movie-container">
        @foreach($films as $film)
        <a href="{{ route('films.show', $film) }}" class="movie-card">
            <img src="{{ $film->poster_url }}" alt="{{ $film->title }}">
        </a>
        @endforeach
    </div>

    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
        {{ $films->links() }}
    </div>
</section>
@endsection