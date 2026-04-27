<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationSiege extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'siege_id',
        'seance_id',
    ];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function siege(): BelongsTo
    {
        return $this->belongsTo(Siege::class);
    }

    public function seance(): BelongsTo
    {
        return $this->belongsTo(Seance::class);
    }
}
