@extends('admin.layout')
@section('page-title', 'Edit Film: ' . $film->title)
@section('content')
<form action="{{ route('admin.films.update', $film) }}" method="POST" enctype="multipart/form-data" style="max-width: 600px;">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label>Judul Film</label>
        <input type="text" name="title" value="{{ old('title', $film->title) }}" required>
        @error('title') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="description" required>{{ old('description', $film->description) }}</textarea>
        @error('description') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    
    <div class="form-group">
        <label>Genre</label>
        <select name="genre_id" required>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}" {{ old('genre_id', $film->genre_id) == $genre->id ? 'selected' : '' }}>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
        @error('genre_id') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    
    <div class="form-group">
        <label>Durasi (menit)</label>
        <input type="number" name="duration" value="{{ old('duration', $film->duration) }}" required>
        @error('duration') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    
    <div class="form-group">
        <label>Tahun Rilis</label>
        <input type="number" name="release_year" value="{{ old('release_year', $film->release_year) }}" required>
        @error('release_year') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    
    <div class="form-group">
        <label>Direktur</label>
        <input type="text" name="director" value="{{ old('director', $film->director) }}" required>
        @error('director') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    
    <div class="form-group">
        <label>Poster Image</label>
        @if($film->poster_url)
            <div style="margin-bottom: 10px;">
                <img src="{{ asset($film->poster_url) }}" alt="Current Poster" style="max-width: 200px; border-radius: 8px;">
            </div>
        @endif
        <input type="file" name="poster_url" accept="image/*">
        <small style="color: #b0b0b0;">Kosongkan jika tidak ingin mengubah</small>
        @error('poster_url') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>

    <!-- Backdrop Image (Horizontal) - NEW -->
    <div class="form-group">
        <label>Backdrop Image (Horizontal/Landscape)</label>
        @if($film->backdrop_url)
            <div style="margin-bottom: 10px;">
                <img src="{{ asset($film->backdrop_url) }}" alt="Current Backdrop" style="max-width: 400px; border-radius: 8px;">
            </div>
        @endif
        <input type="file" name="backdrop_url" accept="image/*">
        <small style="color: #b0b0b0;">Untuk hero slider (format landscape) - Kosongkan jika tidak ingin mengubah</small>
        @error('backdrop_url') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    
    <div class="form-group">
        <label>URL Video</label>
        <input type="url" name="video_url" value="{{ old('video_url', $film->video_url) }}">
        @error('video_url') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    
    <div class="form-group">
        <label>Rating (0-10)</label>
        <input type="number" name="rating" value="{{ old('rating', $film->rating) }}" min="0" max="10" step="0.1">
        @error('rating') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    
    <div class="form-group">
        <label>Status</label>
        <select name="status" required>
            <option value="draft" {{ old('status', $film->status) == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status', $film->status) == 'published' ? 'selected' : '' }}>Published</option>
            <option value="archived" {{ old('status', $film->status) == 'archived' ? 'selected' : '' }}>Archived</option>
        </select>
        @error('status') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    
    <!-- ✅ CHECKBOX: Featured -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_featured" value="1" 
                {{ old('is_featured', $film->is_featured) ? 'checked' : '' }}>
            Film Pilihan Editor
        </label>
    </div>
    
    <!-- ✅ CHECKBOX: Trending -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_trending" value="1" 
                {{ old('is_trending', $film->is_trending) ? 'checked' : '' }}>
            Film Trending
        </label>
    </div>
    
    <!-- ✅ CHECKBOX: Popular -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_popular" value="1" 
                {{ old('is_popular', $film->is_popular) ? 'checked' : '' }}>
            Film Populer
        </label>
    </div>
    <!-- ✅ CHECKBOX: Hero Slider -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_hero" value="1" 
                {{ old('is_hero', $film->is_hero) ? 'checked' : '' }}>
            🎬 Tampilkan di Hero Slider (Home)
        </label>
        <small style="display: block; color: #b0b0b0; margin-top: 5px;">
            Film ini akan muncul di slider besar di homepage
        </small>
    </div>
        
    <div style="display: flex; gap: 10px;">
        <button type="submit" class="btn btn-primary">
            💾 Update
        </button>
        <a href="{{ route('admin.films.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </div>
</form>
@endsection