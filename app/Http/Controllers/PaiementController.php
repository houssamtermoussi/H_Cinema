<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PaiementController extends Controller
{
    /**
     * Show the form for creating a new payment.
     */
    public function create(Reservation $reservation): Response|RedirectResponse
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
        ]);

        $reservation = Reservation::with('seance.film')->findOrFail($validated['reservation_id']);

        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $montant = $reservation->seance->prix * $reservation->nombre_places;

        return $request->user()->checkoutCharge(
            $montant * 100,
            'Réservation Cinema: '.$reservation->seance->film->titre,
            1,
            [
                'success_url' => route('paiements.success', $reservation).'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('paiements.cancel', $reservation),
                'metadata' => [
                    'reservation_id' => $reservation->id,
                ],
            ]
        );
    }

    /**
     * Handle successful payment.
     */
    public function success(Request $request, Reservation $reservation): RedirectResponse
    {
        $sessionId = $request->get('session_id');

        if ($sessionId) {
            Paiement::updateOrCreate(
                ['stripe_session_id' => $sessionId],
                [
                    'reservation_id' => $reservation->id,
                    'montant' => $reservation->seance->prix * $reservation->nombre_places,
                    'statut' => 'payé',
                    'methode_paiement' => 'stripe',
                ]
            );

            $reservation->update(['statut' => 'confirmée']);
        }

        return redirect()->route('reservations.show', $reservation)
            ->with('message', 'Paiement effectué avec succès !');
    }

    /**
     * Handle cancelled payment.
     */
    public function cancel(Reservation $reservation): RedirectResponse
    {
        return redirect()->route('paiements.create', $reservation)
            ->with('error', 'Le paiement a été annulé.');
    }
}
