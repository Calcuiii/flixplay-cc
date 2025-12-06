<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class AdminGenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('films')->paginate(15);
        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:genres|max:255',
            'description' => 'nullable|string',
        ]);

        Genre::create($validated);

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil ditambahkan');
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:genres,name,' . $genre->id . '|max:255',
            'description' => 'nullable|string',
        ]);

        $genre->update($validated);

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil diperbarui');
    }

    public function destroy(Genre $genre)
    {
        if ($genre->films()->count() > 0) {
            return redirect()->route('admin.genres.index')->with('error', 'Genre tidak bisa dihapus karena masih memiliki film');
        }

        $genre->delete();
        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil dihapus');
    }
}