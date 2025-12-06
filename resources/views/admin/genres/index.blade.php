@extends('admin.layout')

@section('page-title', 'Manage Genre')

@section('header-actions')
    <a href="{{ route('admin.genres.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah Genre
    </a>
@endsection

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Jumlah Film</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($genres as $genre)
            <tr>
                <td>{{ $genre->name }}</td>
                <td>{{ Str::limit($genre->description, 50) }}</td>
                <td>{{ $genre->films_count }}</td>
                <td style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.genres.edit', $genre) }}" class="btn btn-secondary" style="padding: 8px 15px;">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus genre ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 8px 15px;">
                            🗑️ Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $genres->links() }}
@endsection