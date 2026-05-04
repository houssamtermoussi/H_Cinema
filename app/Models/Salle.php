<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Salle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'capacite',
    ];

    protected function casts(): array
    {
        return [
            'capacite' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (Salle $salle) {
            $capacite = $salle->capacite;
            $cols = 10;
            if ($capacite >= 200) {
                $cols = 20;
            }
            if ($capacite >= 300) {
                $cols = 25;
            }

            $rows = (int) ceil($capacite / $cols);

            $seatCount = 0;
            $alphabet = range('A', 'Z');

            for ($r = 0; $r < $rows; $r++) {
                $rowLetter = $alphabet[$r % 26];
                for ($c = 1; $c <= $cols; $c++) {
                    if ($seatCount >= $capacite) {
                        break 2;
                    }

                    $salle->sieges()->create([
                        'numero' => $rowLetter.$c,
                    ]);
                    $seatCount++;
                }
            }
        });
    }

    public function seances(): HasMany
    {
        return $this->hasMany(Seance::class);
    }

    public function sieges(): HasMany
    {
        return $this->hasMany(Siege::class);
    }
}
