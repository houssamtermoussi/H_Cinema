<?php

namespace Database\Seeders;

use App\Models\Salle;
use Illuminate\Database\Seeder;

class SalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salles = [
            ['nom' => 'Salle 1 - IMAX', 'capacite' => 350],
            ['nom' => 'Salle 2 - 3D', 'capacite' => 200],
            ['nom' => 'Salle 3 ', 'capacite' => 150],
            ['nom' => 'Salle VIP', 'capacite' => 50],
            ['nom' => 'Salle 5 ', 'capacite' => 250],
            ['nom' => 'Salle 6 ', 'capacite' => 100],
        ];

        foreach ($salles as $salle) {
            Salle::create($salle);
        }
    }
}
