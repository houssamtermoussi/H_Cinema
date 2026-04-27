<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = [
        'film_id',
        'salle_id',
        'date_seance',
        'heure_debut',
        'heure_fin',
        'prix',
    ];

    protected function casts(): array
    {
        return [
            'date_seance' => 'date',
            'prix' => 'decimal:2',
        ];
    }

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    public function salle(): BelongsTo
    {
        return $this->belongsTo(Salle::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
