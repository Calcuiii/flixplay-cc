<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;

class AdminFilmController extends Controller
{
    public function index()
    {
        $films = Film::with('genre')
            ->latest()
            ->paginate(15);
        
        return view('admin.films.index', compact('films'));
    }

    public function create()
    {
        $genres = Genre::all();
        return view('admin.films.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|min:3',
            'description' => 'required|string|min:10',
            'genre_id' => 'required|exists:genres,id',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
            'duration' => 'required|integer|min:1|max:600',
            'director' => 'required|string|max:255',
            'poster_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:10',
            'status' => 'required|in:draft,published,archived',
        ]);

        // ✅ Handle poster upload
        if ($request->hasFile('poster_url')) {
            $file = $request->file('poster_url');
            $path = $file->store('posters', 'public');
            $validated['poster_url'] = '/storage/' . $path;
        }

        // ✅ Handle checkboxes
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_trending'] = $request->has('is_trending');
        $validated['is_popular'] = $request->has('is_popular');

        Film::create($validated);

        return redirect()->route('admin.films.index')
            ->with('success', 'Film berhasil ditambahkan');
    }

    public function edit(Film $film)
    {
        $genres = Genre::all();
        return view('admin.films.edit', compact('film', 'genres'));
    }

    public function update(Request $request, Film $film)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|min:3',
            'description' => 'required|string|min:10',
            'genre_id' => 'required|exists:genres,id',
            'duration' => 'required|integer|min:1|max:600',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
            'director' => 'required|string|max:255',
            'poster_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:10',
            'status' => 'required|in:draft,published,archived',
        ]);

        // ✅ Handle poster upload (jika ada file baru)
        if ($request->hasFile('poster_url')) {
            // Hapus poster lama jika ada
            if ($film->poster_url && file_exists(public_path($film->poster_url))) {
                unlink(public_path($film->poster_url));
            }
            
            $file = $request->file('poster_url');
            $path = $file->store('posters', 'public');
            $validated['poster_url'] = '/storage/' . $path;
        } else {
            // Jangan update poster_url jika tidak ada file baru
            unset($validated['poster_url']);
        }

        // ✅ Handle checkboxes
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_trending'] = $request->has('is_trending');
        $validated['is_popular'] = $request->has('is_popular');

        $film->update($validated);

        return redirect()->route('admin.films.index')
            ->with('success', 'Film berhasil diperbarui');
    }

    public function destroy(Film $film)
    {
        // ✅ Hapus file poster saat hapus film
        if ($film->poster_url && file_exists(public_path($film->poster_url))) {
            unlink(public_path($film->poster_url));
        }

        $film->delete();

        return redirect()->route('admin.films.index')
            ->with('success', 'Film berhasil dihapus');
    }
}