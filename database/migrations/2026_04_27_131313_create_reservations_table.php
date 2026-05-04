<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('seance_id')->constrained()->cascadeOnDelete();
            $table->integer('nombre_places');
            $table->enum('statut', ['confirmée', 'annulée', 'en attente'])->default('en attente');
            $table->timestamps();

            $table->index(['user_id', 'seance_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
