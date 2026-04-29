<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FilmController extends Controller
{
    /**
     * Display a listing of films for admin.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Films/Index', [
            'films' => Film::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new film.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Films/Create');
    }

    /**
     * Store a newly created film in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'duree' => 'required|integer|min:1',
            'date_sortie' => 'required|date',
            'affiche' => 'nullable|string', // Placeholder for now, can be changed to file upload later
            'type' => 'required|string',
        ]);

        Film::create($validated);

        return redirect()->route('admin.films.index')->with('message', 'Film créé avec succès.');
    }

    /**
     * Show the form for editing the specified film.
     */
    public function edit(Film $film): Response
    {
        return Inertia::render('Admin/Films/Edit', [
            'film' => $film,
        ]);
    }

    /**
     * Update the specified film in storage.
     */
    public function update(Request $request, Film $film): RedirectResponse
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'duree' => 'required|integer|min:1',
            'date_sortie' => 'required|date',
            'affiche' => 'nullable|string',
            'type' => 'required|string',
        ]);

        $film->update($validated);

        return redirect()->route('admin.films.index')->with('message', 'Film mis à jour avec succès.');
    }

    /**
     * Remove the specified film from storage.
     */
    public function destroy(Film $film): RedirectResponse
    {
        $film->delete();

        return redirect()->route('admin.films.index')->with('message', 'Film supprimé avec succès.');
    }
}
