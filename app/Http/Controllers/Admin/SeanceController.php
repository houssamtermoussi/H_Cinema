<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Salle;
use App\Models\Seance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SeanceController extends Controller
{
    /**
     * Display a listing of showtimes for admin.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Seances/Index', [
            'seances' => Seance::with(['film', 'salle'])->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new showtime.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Seances/Create', [
            'films' => Film::select('id', 'titre')->get(),
            'salles' => Salle::select('id', 'nom')->get(),
        ]);
    }

    /**
     * Store a newly created showtime in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'film_id' => 'required|exists:films,id',
            'salle_id' => 'required|exists:salles,id',
            'date_seance' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'prix' => 'required|numeric|min:0',
        ]);

        Seance::create($validated);

        return redirect()->route('admin.seances.index')->with('message', 'Séance créée avec succès.');
    }

    /**
     * Show the form for editing the specified showtime.
     */
    public function edit(Seance $seance): Response
    {
        return Inertia::render('Admin/Seances/Edit', [
            'seance' => $seance,
            'films' => Film::select('id', 'titre')->get(),
            'salles' => Salle::select('id', 'nom')->get(),
        ]);
    }

    /**
     * Update the specified showtime in storage.
     */
    public function update(Request $request, Seance $seance): RedirectResponse
    {
        $validated = $request->validate([
            'film_id' => 'required|exists:films,id',
            'salle_id' => 'required|exists:salles,id',
            'date_seance' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'prix' => 'required|numeric|min:0',
        ]);

        $seance->update($validated);

        return redirect()->route('admin.seances.index')->with('message', 'Séance mise à jour avec succès.');
    }

    /**
     * Remove the specified showtime from storage.
     */
    public function destroy(Seance $seance): RedirectResponse
    {
        $seance->delete();

        return redirect()->route('admin.seances.index')->with('message', 'Séance supprimée avec succès.');
    }
}
