@extends('admin.layout')

@section('page-title', 'Tambah Genre Baru')

@section('content')
<form action="{{ route('admin.genres.store') }}" method="POST" style="max-width: 600px;">
    @csrf

    <div class="form-group">
        <label>Nama Genre</label>
        <input type="text" name="name" required>
        @error('name') <span style="color: #e94b3c;">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="description"></textarea>
    </div>

    <div style="display: flex; gap: 10px;">
        <button type="submit" class="btn btn-primary">
            💾 Simpan
        </button>
        <a href="{{ route('admin.genres.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </div>
</form>
@endsection