@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . $keyword)

@section('content')
<section class="category-section">
    <h2 class="category-title">🔍 Hasil Pencarian: "{{ $keyword }}"</h2>
    
    @if($films->count() > 0)
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
    @else
    <p style="text-align: center; padding: 30px; color: #b0b0b0;">Tidak ada film yang cocok dengan pencarian Anda.</p>
    @endif
</section>
@endsection