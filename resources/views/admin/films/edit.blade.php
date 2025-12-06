@extends('admin.layout')

@section('page-title', 'Edit Film: ' . $film->title)

@section('content')
<form action="{{ route('admin.films.update', $film) }}" method="POST" enctype="multipart/form-data" style="max-width: 600px;">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Judul Film</label>
        <input type="text" name="title" value="{{ $film->title }}" required>
    </div>

    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="description" required>{{ $film->description }}</textarea>
    </div>

    <div class="form-group">
        <label>Genre</label>
        <select name="genre_id" required>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}" {{ $film->genre_id == $genre->id ? 'selected' : '' }}>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Durasi (menit)</label>
        <input type="number" name="duration" value="{{ $film->duration }}" required>
    </div>

    <div class="form-group">
        <label>Tahun Rilis</label>
        <input type="number" name="release_year" value="{{ $film->release_year }}" required>
    </div>

    <div class="form-group">
        <label>Direktur</label>
        <input type="text" name="director" value="{{ $film->director }}" required>
    </div>

    <div class="form-group">
        <label>Poster Image</label>
        <input type="file" name="poster_url" accept="image/*">
        <small style="color: #b0b0b0;">Kosongkan jika tidak ingin mengubah</small>
    </div>

    <div class="form-group">
        <label>URL Video</label>
        <input type="url" name="video_url" value="{{ $film->video_url }}">
    </div>

    <div class="form-group">
        <label>Rating (0-10)</label>
        <input type="number" name="rating" value="{{ $film->rating }}" min="0" max="10" step="0.1">
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" required>
            <option value="draft" {{ $film->status == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ $film->status == 'published' ? 'selected' : '' }}>Published</option>
            <option value="archived" {{ $film->status == 'archived' ? 'selected' : '' }}>Archived</option>
        </select>
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