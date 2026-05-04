<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends CashierController
{
    /**
     * Handle checkout session completed.
     */
    protected function handleCheckoutSessionCompleted(array $payload): Response
    {
        $session = $payload['data']['object'];

        // Find the reservation from metadata
        $reservationId = $session['metadata']['reservation_id'] ?? null;

        if ($reservationId) {
            $reservation = Reservation::find($reservationId);

            if ($reservation && $reservation->statut !== 'confirmée') {
                $reservation->update(['statut' => 'confirmée']);

                Paiement::updateOrCreate(
                    ['stripe_session_id' => $session['id']],
                    [
                        'reservation_id' => $reservation->id,
                        'montant' => $session['amount_total'] / 100,
                        'statut' => 'payé',
                        'methode_paiement' => 'stripe',
                    ]
                );
            }
        }

        return $this->successMethod();
    }
}
