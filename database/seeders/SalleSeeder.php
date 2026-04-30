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

        foreach ($salles as $salleData) {
            $salle = Salle::create($salleData);

            $capacite = $salleData['capacite'];
            $cols = 10;
            if ($capacite >= 200) $cols = 20;
            if ($capacite >= 300) $cols = 25;
            
            $rows = ceil($capacite / $cols);
            
            $seatCount = 0;
            $alphabet = range('A', 'Z');
            
            for ($r = 0; $r < $rows; $r++) {
                $rowLetter = $alphabet[$r % 26];
                for ($c = 1; $c <= $cols; $c++) {
                    if ($seatCount >= $capacite) break 2;
                    
                    $salle->sieges()->create([
                        'numero' => $rowLetter . $c
                    ]);
                    $seatCount++;
                }
            }
        }
    }
}
