<?php

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can access their own payment page', function () {
    $user = User::factory()->create();
    $reservation = Reservation::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)
        ->get(route('paiements.create', $reservation));

    $response->assertStatus(200);
});

test('user cannot access someone else payment page', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $reservation = Reservation::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($user)
        ->get(route('paiements.create', $reservation));

    $response->assertRedirect(route('reservations.show', $reservation));
});

test('successful payment updates reservation status', function () {
    $user = User::factory()->create();
    $reservation = Reservation::factory()->create([
        'user_id' => $user->id,
        'statut' => 'en attente',
    ]);

    $sessionId = 'sess_test_123';

    $response = $this->actingAs($user)
        ->get(route('paiements.success', $reservation)."?session_id=$sessionId");

    $response->assertRedirect(route('reservations.show', $reservation));
    $response->assertSessionHas('message', 'Paiement effectué avec succès !');

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'statut' => 'confirmée',
    ]);

    $this->assertDatabaseHas('paiements', [
        'reservation_id' => $reservation->id,
        'stripe_session_id' => $sessionId,
        'statut' => 'payé',
    ]);
});

test('cancelled payment redirects back with error', function () {
    $user = User::factory()->create();
    $reservation = Reservation::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)
        ->get(route('paiements.cancel', $reservation));

    $response->assertRedirect(route('paiements.create', $reservation));
    $response->assertSessionHas('error', 'Le paiement a été annulé.');
});
