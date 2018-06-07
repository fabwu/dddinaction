<?php


namespace App\Infrastructure;


use App\Domain\Atm\PaymentGateway;

class PaymentGatewayStub implements PaymentGateway
{
    public function chargePayment(float $amount): void
    {
        // TODO: Implement chargePayment() method.
    }
}