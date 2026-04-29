<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReservationController extends Controller
{
    /**
     * Display a listing of all reservations for admin.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Reservations/Index', [
            'reservations' => Reservation::with(['user', 'seance.film', 'seance.salle', 'paiement'])
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Update the status of a reservation.
     */
    public function update(Request $request, Reservation $reservation): RedirectResponse
    {
        $validated = $request->validate([
            'statut' => 'required|string|in:en_attente,confirme,annule',
        ]);

        $reservation->update($validated);

        return redirect()->route('admin.reservations.index')->with('message', 'Statut de la réservation mis à jour.');
    }

    /**
     * Remove a reservation.
     */
    public function destroy(Reservation $reservation): RedirectResponse
    {
        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('message', 'Réservation supprimée.');
    }
}
