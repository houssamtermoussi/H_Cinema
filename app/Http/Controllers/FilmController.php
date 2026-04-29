<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Inertia\Inertia;
use Inertia\Response;

class FilmController extends Controller
{
    /**
     * Display a listing of films.
     */
    public function index(): Response
    {
        return Inertia::render('Films/Index', [
            'films' => Film::all(),
        ]);
    }

    /**
     * Display the specified film with its sessions.
     */
    public function show(Film $film): Response
    {
        return Inertia::render('Films/Show', [
            'film' => $film->load(['seances' => function ($query) {
                $query->with('salle')->where('date_seance', '>=', now()->toDateString());
            }]),
        ]);
    }
}
