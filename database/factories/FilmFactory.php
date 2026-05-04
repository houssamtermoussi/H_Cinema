<?php

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'duree' => $this->faker->numberBetween(60, 240),
            'date_sortie' => $this->faker->date(),
            'affiche' => $this->faker->imageUrl(),
            'type' => $this->faker->randomElement(['Action', 'Comédie', 'Drame', 'Horreur', 'Science-Fiction']),
        ];
    }
}
