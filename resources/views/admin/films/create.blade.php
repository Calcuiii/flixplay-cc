@extends('admin.layout')
@section('page-title', 'Tambah Film Baru')
@section('content')
<form action="{{ route('admin.films.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 600px;">
    @csrf
    <div class="form-group">
        <label>Judul Film</label>
        <input type="text" name="title" value="{{ old('title') }}" required>
        @error('title') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="description" required>{{ old('description') }}</textarea>
        @error('description') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>Genre</label>
        <select name="genre_id" required>
            <option value="">-- Pilih Genre --</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
        @error('genre_id') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>Durasi (menit)</label>
        <input type="number" name="duration" value="{{ old('duration') }}" required>
        @error('duration') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>Tahun Rilis</label>
        <input type="number" name="release_year" value="{{ old('release_year') }}" required>
        @error('release_year') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>Direktur</label>
        <input type="text" name="director" value="{{ old('director') }}" required>
        @error('director') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>Poster Image</label>
        <input type="file" name="poster_url" accept="image/*">
        @error('poster_url') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>URL Video</label>
        <input type="url" name="video_url" value="{{ old('video_url') }}">
        @error('video_url') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>Rating (0-10)</label>
        <input type="number" name="rating" min="0" max="10" step="0.1" value="{{ old('rating') }}">
        @error('rating') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" required>
            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
        </select>
        @error('status') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>
    
    <!-- ✅ CHECKBOX: Featured -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
            Film Pilihan Editor
        </label>
    </div>
    
    <!-- ✅ CHECKBOX: Trending -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_trending" value="1" {{ old('is_trending') ? 'checked' : '' }}>
            Film Trending
        </label>
    </div>
    
    <!-- ✅ CHECKBOX: Popular -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_popular" value="1" {{ old('is_popular') ? 'checked' : '' }}>
            Film Populer
        </label>
    </div>
    
    <div style="display: flex; gap: 10px;">
        <button type="submit" class="btn btn-primary">
            💾 Simpan
        </button>
        <a href="{{ route('admin.films.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </div>
</form>
@endsection