<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Salle;
use App\Models\Seance;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SeanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = Film::all();
        $salles = Salle::all();

        // On s'assure d'avoir au moins 2 salles et des films
        if ($salles->count() < 2 || $films->isEmpty()) {
            return;
        }

        $startDate = Carbon::today()->addDays(1);
        $heuresPossibles = ['14:00', '16:30', '19:00', '21:30'];

        foreach ($films as $film) {
            // Sélectionner 2 salles différentes au hasard pour ce film
            $sallesSelectionnees = $salles->random(2);

            foreach ($sallesSelectionnees as $salle) {
                // Déterminer une date aléatoire dans les 7 prochains jours
                $dateSeance = clone $startDate;
                $dateSeance->addDays(rand(0, 6));

                $heureDebutString = $heuresPossibles[array_rand($heuresPossibles)];
                $heureDebut = Carbon::createFromFormat('H:i', $heureDebutString);

                // Calcul de l'heure de fin (durée du film + 20 minutes de battement)
                $dureeMinutes = $film->duree > 0 ? $film->duree : 120;
                $heureFin = (clone $heureDebut)->addMinutes($dureeMinutes + 20);

                // Tarification en fonction de la salle
                $prix = 12.50; // Prix standard
                if (str_contains($salle->nom, 'VIP')) {
                    $prix = 25.00;
                } elseif (str_contains($salle->nom, 'IMAX') || str_contains($salle->nom, 'Dolby')) {
                    $prix = 16.00;
                } elseif (str_contains($salle->nom, '3D')) {
                    $prix = 14.50;
                }

                Seance::create([
                    'film_id' => $film->id,
                    'salle_id' => $salle->id,
                    'date_seance' => $dateSeance->format('Y-m-d'),
                    'heure_debut' => $heureDebut->format('H:i:s'),
                    'heure_fin' => $heureFin->format('H:i:s'),
                    'prix' => $prix,
                ]);
            }
        }
    }
}
