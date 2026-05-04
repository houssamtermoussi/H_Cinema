<?php

use App\Models\Salle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('seats are automatically generated when a salle is created', function () {
    $salle = Salle::create([
        'nom' => 'Test Salle',
        'capacite' => 50,
    ]);

    expect($salle->sieges()->count())->toBe(50);

    // Check first and last seat format
    $firstSeat = $salle->sieges()->orderBy('id')->first();
    $lastSeat = $salle->sieges()->orderBy('id', 'desc')->first();

    expect($firstSeat->numero)->toBe('A1');
    // For 50 capacity, 10 cols, that's 5 rows (A to E)
    // Row E, Col 10
    expect($lastSeat->numero)->toBe('E10');
});

test('seats are generated with different column counts based on capacity', function () {
    // Large salle (300+ capacity) should use 25 columns
    $largeSalle = Salle::create([
        'nom' => 'Large Salle',
        'capacite' => 300,
    ]);

    expect($largeSalle->sieges()->count())->toBe(300);

    // 300 / 25 = 12 rows (A to L)
    $lastSeat = $largeSalle->sieges()->orderBy('id', 'desc')->first();
    expect($lastSeat->numero)->toBe('L25');
});

test('admin can create a salle and seats are generated', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.salles.store'), [
            'nom' => 'Admin Salle',
            'capacite' => 20,
        ])
        ->assertRedirect(route('admin.salles.index'));

    $salle = Salle::where('nom', 'Admin Salle')->first();
    expect($salle)->not->toBeNull();
    expect($salle->sieges()->count())->toBe(20);
});
