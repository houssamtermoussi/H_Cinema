<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation_sieges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('siege_id')->constrained()->cascadeOnDelete();
            
            // Pour garantir qu'un siège ne soit pas réservé deux fois pour la même séance
            // On ajoute seance_id dans cette table de liaison.
            $table->foreignId('seance_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // L'utilisateur demande: (siege_id, reservation_id) unique
            $table->unique(['siege_id', 'reservation_id']);
            
            // Contrainte logique critique : Un siège ne peut pas être réservé plus d'une fois pour la même séance.
            $table->unique(['siege_id', 'seance_id'], 'unique_siege_seance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_sieges');
    }
};
