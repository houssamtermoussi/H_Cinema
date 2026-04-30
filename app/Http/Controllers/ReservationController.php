<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationSiege;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ReservationController extends Controller
{
    /**
     * Display a listing of the user's reservations.
     */
    public function index(): Response
    {
        return Inertia::render('Reservations/Index', [
            'reservations' => auth()->user()->reservations()
                ->with(['seance.film', 'seance.salle', 'paiement'])
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'seance_id' => 'required|exists:seances,id',
            'siege_ids' => 'required|array|min:1',
            'siege_ids.*' => 'exists:sieges,id',
        ]);

        return DB::transaction(function () use ($validated) {
            // Logic to check if seats are already taken could be added here

            $reservation = Reservation::create([
                'user_id' => auth()->id(),
                'seance_id' => $validated['seance_id'],
                'nombre_places' => count($validated['siege_ids']),
                'statut' => 'en attente',
            ]);

            foreach ($validated['siege_ids'] as $siegeId) {
                ReservationSiege::create([
                    'reservation_id' => $reservation->id,
                    'siege_id' => $siegeId,
                    'seance_id' => $validated['seance_id'],
                ]);
            }

            return redirect()->route('paiements.create', ['reservation' => $reservation->id]);
        });
    }

    /**
     * Display the specified reservation.
     */
    public function show(Reservation $reservation): Response
    {
        // Ensure user owns the reservation
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Reservations/Show', [
            'reservation' => $reservation->load([
                'seance.film',
                'seance.salle',
                'reservationSieges.siege',
                'paiement',
            ]),
        ]);
    }
}
