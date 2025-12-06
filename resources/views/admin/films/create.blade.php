@extends('admin.layout')

@section('page-title', 'Tambah Film Baru')

@section('content')
<form action="{{ route('admin.films.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 600px;">
    @csrf

    <div class="form-group">
        <label>Judul Film</label>
        <input type="text" name="title" required>
        @error('title') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="description" required></textarea>
        @error('description') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Genre</label>
        <select name="genre_id" required>
            <option value="">-- Pilih Genre --</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
        </select>
        @error('genre_id') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Durasi (menit)</label>
        <input type="number" name="duration" required>
        @error('duration') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Tahun Rilis</label>
        <input type="number" name="release_year" required>
        @error('release_year') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Direktur</label>
        <input type="text" name="director" required>
        @error('director') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Poster Image</label>
        <input type="file" name="poster_url" accept="image/*">
        @error('poster_url') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>URL Video</label>
        <input type="url" name="video_url">
        @error('video_url') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Rating (0-10)</label>
        <input type="number" name="rating" min="0" max="10" step="0.1">
        @error('rating') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" required>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
        </select>
        @error('status') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
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