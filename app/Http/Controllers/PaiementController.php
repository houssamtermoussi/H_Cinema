<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PaiementController extends Controller
{
    /**
     * Show the form for creating a new payment.
     */
    public function create(Reservation $reservation): Response
    {
        // Ensure user owns the reservation and it's in a payable state
        if ($reservation->user_id !== auth()->id() || $reservation->statut === 'confirmée') {
            return redirect()->route('reservations.show', $reservation);
        }

        return Inertia::render('Paiements/Create', [
            'reservation' => $reservation->load('seance.film'),
            'montant' => $reservation->seance->prix * $reservation->nombre_places,
        ]);
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'methode_paiement' => 'required|string',
        ]);

        $reservation = Reservation::with('seance')->findOrFail($validated['reservation_id']);

        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        return DB::transaction(function () use ($reservation, $validated) {
            $paiement = Paiement::create([
                'reservation_id' => $reservation->id,
                'montant' => $reservation->seance->prix * $reservation->nombre_places,
                'statut' => 'complete',
                'methode_paiement' => $validated['methode_paiement'],
            ]);

            $reservation->update(['statut' => 'confirmée']);

            return redirect()->route('reservations.show', $reservation)
                ->with('message', 'Paiement effectué avec succès !');
        });
    }
}
