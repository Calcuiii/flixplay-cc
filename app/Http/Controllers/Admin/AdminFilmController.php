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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
            'duration' => 'required|integer|min:1',
            'release_year' => 'required|integer|min:1900',
            'director' => 'required|string|max:255',
            'poster_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:10',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Handle image upload
        if ($request->hasFile('poster_url')) {
            $file = $request->file('poster_url');
            $path = $file->store('posters', 'public');
            $validated['poster_url'] = '/storage/' . $path;
        }

        Film::create($validated);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil ditambahkan');
    }

    public function edit(Film $film)
    {
        $genres = Genre::all();
        return view('admin.films.edit', compact('film', 'genres'));
    }

    public function update(Request $request, Film $film)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
            'duration' => 'required|integer|min:1',
            'release_year' => 'required|integer|min:1900',
            'director' => 'required|string|max:255',
            'poster_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:10',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($request->hasFile('poster_url')) {
            $file = $request->file('poster_url');
            $path = $file->store('posters', 'public');
            $validated['poster_url'] = '/storage/' . $path;
        }

        $film->update($validated);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil diperbarui');
    }

    public function destroy(Film $film)
    {
        $film->delete();
        return redirect()->route('admin.films.index')->with('success', 'Film berhasil dihapus');
    }
}