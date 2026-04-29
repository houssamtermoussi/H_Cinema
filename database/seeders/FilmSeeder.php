<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = [
            [
                'titre' => 'Avatar: La Voie de l\'eau',
                'description' => 'Jake Sully vit avec sa nouvelle famille sur la lune extrasolaire Pandora. Lorsqu\'une menace familière revient...',
                'duree' => 192,
                'date_sortie' => '2022-12-14',
                'affiche' => '/images/posters/avatar.jpg',
                'type' => 'Sci-Fi',
            ],
            [
                'titre' => 'Avengers: Endgame',
                'description' => 'Après les événements dévastateurs d\'Infinity War, l\'univers est en ruines. Avec l\'aide des alliés restants, les Avengers se rassemblent une fois de plus...',
                'duree' => 181,
                'date_sortie' => '2019-04-24',
                'affiche' => '/images/posters/avengersendgame.jpg',
                'type' => 'Action',
            ],
            [
                'titre' => 'Dune: Troisième Partie',
                'description' => 'La suite du voyage de Paul Atréides qui embrasse son destin sur la planète désertique d\'Arrakis...',
                'duree' => 165,
                'date_sortie' => '2026-12-18',
                'affiche' => '/images/posters/dune3.jpg',
                'type' => 'Sci-Fi',
            ],
            [
                'titre' => 'F1: Apex',
                'description' => 'Un vétéran de la Formule 1 sort de sa retraite pour encadrer un jeune prodige et tenter une dernière fois de décrocher la gloire.',
                'duree' => 2,
                'date_sortie' => '2025-06-25',
                'affiche' => '/images/posters/f1.webp',
                'type' => 'Drama',
            ],
            [
                'titre' => 'Fast X',
                'description' => 'Dom Toretto et sa famille sont pris pour cible par le fils vengeur du baron de la drogue Hernan Reyes.',
                'duree' => 141,
                'date_sortie' => '2023-05-17',
                'affiche' => '/images/posters/fastandfurious.jpg',
                'type' => 'Action',
            ],
            [
                'titre' => 'Sur la piste du Marsupilami',
                'description' => 'Un reporter se rend en Palombie pour trouver le mythique Marsupilami, affrontant diverses situations comiques et dangereuses.',
                'duree' => 105,
                'date_sortie' => '2018-04-04',
                'affiche' => '/images/posters/marsupilami.jpg',
                'type' => 'Comedy',
            ],
            [
                'titre' => 'Michael',
                'description' => 'Un regard complet sur la vie et la carrière du roi de la pop, Michael Jackson.',
                'duree' => 155,
                'date_sortie' => '2025-04-18',
                'affiche' => '/images/posters/michaeljackson.jpg',
                'type' => 'Biography',
            ],
            [
                'titre' => 'Spider-Man: No Way Home',
                'description' => 'L\'identité de Spider-Man étant désormais révélée, Peter demande l\'aide du docteur Strange. Lorsqu\'un sort tourne mal, de dangereux ennemis commencent à apparaître.',
                'duree' => 148,
                'date_sortie' => '2021-12-15',
                'affiche' => '/images/posters/spidermannowayhome.webp',
                'type' => 'Action',
            ],
            [
                'titre' => 'The Drama',
                'description' => 'La relation d\'un couple est mise à l\'épreuve quelques jours seulement avant leur mariage lorsque des révélations inattendues sont dévoilées.',
                'duree' => 110,
                'date_sortie' => '2025-09-12',
                'affiche' => '/images/posters/thedrama.jpg',
                'type' => 'Drama',
            ],
            [
                'titre' => 'The Super Mario Galaxy Movie',
                'description' => 'Mario et Luigi se lancent dans une aventure cosmique pour sauver la princesse Peach et la galaxie entière des griffes de Bowser.',
                'duree' => 95,
                'date_sortie' => '2026-04-05',
                'affiche' => '/images/posters/thesupermariogalaxy.jpg',
                'type' => 'Animation',
            ],
            [
                'titre' => 'Titanic: L\'histoire secrète',
                'description' => 'Une nouvelle perspective sur le naufrage tragique du RMS Titanic, se concentrant sur les histoires inédites des passagers.',
                'duree' => 150,
                'date_sortie' => '2019-11-20',
                'affiche' => '/images/posters/titanic.webp',
                'type' => 'Romance',
            ],
            [
                'titre' => 'Toy Story 5',
                'description' => 'Woody et Buzz se retrouvent pour une dernière aventure qui les mènera plus loin qu\'ils ne l\'ont jamais été.',
                'duree' => 100,
                'date_sortie' => '2026-06-19',
                'affiche' => '/images/posters/toystory.jpg',
                'type' => 'Animation',
            ],
        ];

        foreach ($films as $film) {
            Film::create($film);
        }
    }
}
