@extends('admin.layout')

@section('page-title', 'Edit Genre: ' . $genre->name)

@section('content')
<form action="{{ route('admin.genres.update', $genre) }}" method="POST" style="max-width: 600px;">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Nama Genre</label>
        <input type="text" name="name" value="{{ $genre->name }}" required>
    </div>

    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="description">{{ $genre->description }}</textarea>
    </div>

    <div style="display: flex; gap: 10px;">
        <button type="submit" class="btn btn-primary">
            💾 Update
        </button>
        <a href="{{ route('admin.genres.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </div>
</form>
@endsection