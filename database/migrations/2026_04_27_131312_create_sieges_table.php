<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sieges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salle_id')->constrained()->cascadeOnDelete();
            $table->string('numero');
            $table->timestamps();

            $table->unique(['salle_id', 'numero']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sieges');
    }
};
