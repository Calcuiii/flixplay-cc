@extends('admin.layout')
@section('page-title', 'Manage Film')
@section('header-actions')
    <a href="{{ route('admin.films.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah Film
    </a>
@endsection
@section('content')

@if(session('success'))
    <div style="background: rgba(76, 175, 80, 0.1); color: #4CAF50; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #4CAF50;">
        ✅ {{ session('success') }}
    </div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Genre</th>
            <th>Tahun</th>
            <th>Rating</th>
            <th>Status</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($films as $film)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        @if($film->poster_url)
                            <img src="{{ asset($film->poster_url) }}" alt="{{ $film->title }}" 
                                 style="width: 50px; height: 75px; object-fit: cover; border-radius: 4px;">
                        @endif
                        <div>
                            <strong>{{ $film->title }}</strong>
                            <br>
                            <small style="color: #b0b0b0;">{{ $film->director ?? '-' }}</small>
                        </div>
                    </div>
                </td>
                <td>{{ $film->genre->name }}</td>
                <td>{{ $film->release_year }}</td>
                <td>⭐ {{ number_format($film->rating, 1) }}</td>
                <td>
                    @if($film->status == 'published')
                        <span style="background: rgba(76, 175, 80, 0.2); color: #4CAF50; padding: 5px 10px; border-radius: 4px; font-size: 12px;">
                            Published
                        </span>
                    @elseif($film->status == 'draft')
                        <span style="background: rgba(255, 152, 0, 0.2); color: #FF9800; padding: 5px 10px; border-radius: 4px; font-size: 12px;">
                            Draft
                        </span>
                    @else
                        <span style="background: rgba(158, 158, 158, 0.2); color: #9E9E9E; padding: 5px 10px; border-radius: 4px; font-size: 12px;">
                            Archived
                        </span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        @if($film->is_featured)
                            <span style="background: rgba(76, 175, 80, 0.2); color: #4CAF50; padding: 3px 8px; border-radius: 4px; font-size: 11px; display: inline-block;">
                                ✨ Featured
                            </span>
                        @endif
                        @if($film->is_trending)
                            <span style="background: rgba(255, 87, 34, 0.2); color: #FF5722; padding: 3px 8px; border-radius: 4px; font-size: 11px; display: inline-block;">
                                🔥 Trending
                            </span>
                        @endif
                        @if($film->is_popular)
                            <span style="background: rgba(33, 150, 243, 0.2); color: #2196F3; padding: 3px 8px; border-radius: 4px; font-size: 11px; display: inline-block;">
                                ⭐ Popular
                            </span>
                        @endif
                        @if(!$film->is_featured && !$film->is_trending && !$film->is_popular)
                            <span style="color: #666; font-size: 11px;">-</span>
                        @endif
                    </div>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.films.edit', $film) }}" class="btn btn-secondary" style="padding: 8px 15px; text-decoration: none;">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('admin.films.destroy', $film) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus film \'{{ $film->title }}\'?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 8px 15px;">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 40px; color: #b0b0b0;">
                    <i class="bi bi-film" style="font-size: 48px; display: block; margin-bottom: 10px;"></i>
                    Belum ada film. <a href="{{ route('admin.films.create') }}" style="color: #e94b3c;">Tambah film pertama</a>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($films->hasPages())
    <div style="margin-top: 20px;">
        {{ $films->links() }}
    </div>
@endif

@endsection