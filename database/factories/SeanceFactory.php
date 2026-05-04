<?php

namespace Database\Factories;

use App\Models\Film;
use App\Models\Salle;
/**
 * @extends Factory<Seance>
 */
use App\Models\Seance;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'film_id' => Film::factory(),
            'salle_id' => Salle::factory(),
            'date_seance' => $this->faker->date(),
            'heure_debut' => '14:00:00',
            'heure_fin' => '16:00:00',
            'prix' => $this->faker->randomFloat(2, 5, 20),
        ];
    }
}
