<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Seance;
/**
 * @extends Factory<Reservation>
 */
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'seance_id' => Seance::factory(),
            'nombre_places' => $this->faker->numberBetween(1, 10),
            'statut' => 'en attente',
        ];
    }
}
