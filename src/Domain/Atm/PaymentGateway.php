<?php


namespace App\Domain\Atm;


interface PaymentGateway
{
    public function chargePayment(float $amount): void;
}