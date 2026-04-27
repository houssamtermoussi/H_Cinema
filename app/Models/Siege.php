<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siege extends Model
{
    use HasFactory;

    protected $fillable = [
        'salle_id',
        'numero',
    ];

    public function salle(): BelongsTo
    {
        return $this->belongsTo(Salle::class);
    }

    public function reservationSieges(): HasMany
    {
        return $this->hasMany(ReservationSiege::class);
    }
}
