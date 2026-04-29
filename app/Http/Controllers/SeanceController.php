<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use Inertia\Inertia;
use Inertia\Response;

class SeanceController extends Controller
{
    /**
     * Display the specified showtime with seat availability.
     */
    public function show(Seance $seance): Response
    {
        return Inertia::render('Seances/Show', [
            'seance' => $seance->load([
                'film',
                'salle.sieges',
                'reservations.reservationSieges',
            ]),
        ]);
    }
}
