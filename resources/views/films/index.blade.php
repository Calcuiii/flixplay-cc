@extends('layouts.app')

@section('title', 'Semua Film')

@section('content')
<section class="category-section">
    <h2 class="category-title">📽️ SEMUA FILM</h2>
    <div class="movie-container">
        @foreach($films as $film)
        <a href="{{ route('films.show', $film) }}" class="movie-card">
            <img src="{{ $film->poster_url }}" alt="{{ $film->title }}">
        </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
        {{ $films->links() }}
    </div>
</section>
@endsection