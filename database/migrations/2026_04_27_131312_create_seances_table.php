<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained()->cascadeOnDelete();
            $table->foreignId('salle_id')->constrained()->cascadeOnDelete();
            $table->date('date_seance');
            $table->time('heure_debut');
            $table->time('heure_fin')->nullable();
            $table->decimal('prix', 8, 2);
            $table->timestamps();

            $table->index(['film_id', 'date_seance']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};
