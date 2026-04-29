<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index(): Response
    {
        $user = auth()->user();

        return Inertia::render('Dashboard', [
            'recent_reservations' => $user->reservations()
                ->with(['seance.film', 'seance.salle'])
                ->latest()
                ->take(5)
                ->get(),
            'total_bookings' => $user->reservations()->count(),
            'confirmed_bookings' => $user->reservations()->where('statut', 'confirme')->count(),
        ]);
    }
}
