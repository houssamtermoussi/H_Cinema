<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'duree',
        'date_sortie',
        'affiche',
    ];

    protected function casts(): array
    {
        return [
            'date_sortie' => 'date',
            'duree' => 'integer',
        ];
    }

    public function seances(): HasMany
    {
        return $this->hasMany(Seance::class);
    }
}
