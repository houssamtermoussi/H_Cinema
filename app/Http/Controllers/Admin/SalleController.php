<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Salle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SalleController extends Controller
{
    /**
     * Display a listing of rooms (salles) for admin.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Salles/Index', [
            'salles' => Salle::withCount('sieges')->get(),
        ]);
    }

    /**
     * Show the form for creating a new room.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Salles/Create');
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
        ]);

        Salle::create($validated);

        return redirect()->route('admin.salles.index')->with('message', 'Salle créée avec succès.');
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Salle $salle): Response
    {
        return Inertia::render('Admin/Salles/Edit', [
            'salle' => $salle,
        ]);
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Salle $salle): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
        ]);

        $salle->update($validated);

        return redirect()->route('admin.salles.index')->with('message', 'Salle mise à jour avec succès.');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Salle $salle): RedirectResponse
    {
        $salle->delete();

        return redirect()->route('admin.salles.index')->with('message', 'Salle supprimée avec succès.');
    }
}
