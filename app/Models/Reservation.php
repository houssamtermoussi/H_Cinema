<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seance_id',
        'nombre_places',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'nombre_places' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seance(): BelongsTo
    {
        return $this->belongsTo(Seance::class);
    }

    public function reservationSieges(): HasMany
    {
        return $this->hasMany(ReservationSiege::class);
    }

    public function paiement(): HasOne
    {
        return $this->hasOne(Paiement::class);
    }
}
