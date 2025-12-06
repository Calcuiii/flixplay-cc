@extends('admin.layout')

@section('page-title', 'Manage Film')

@section('header-actions')
    <a href="{{ route('admin.films.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah Film
    </a>
@endsection

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Genre</th>
            <th>Tahun</th>
            <th>Rating</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($films as $film)
            <tr>
                <td>{{ $film->title }}</td>
                <td>{{ $film->genre->name }}</td>
                <td>{{ $film->release_year }}</td>
                <td>⭐ {{ $film->rating }}</td>
                <td>
                    <span style="background: linear-gradient(135deg, rgba(233, 75, 60, 0.2), rgba(233, 75, 60, 0.1)); color: #e94b3c; padding: 5px 10px; border-radius: 4px; font-size: 12px;">
                        {{ ucfirst($film->status) }}
                    </span>
                </td>
                <td style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.films.edit', $film) }}" class="btn btn-secondary" style="padding: 8px 15px;">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('admin.films.destroy', $film) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus film ini?');">
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

{{ $films->links() }}
@endsection