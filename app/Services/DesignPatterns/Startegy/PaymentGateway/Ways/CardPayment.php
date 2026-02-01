<?php

namespace App\Services\DesignPatterns\Startegy\PaymentGateway\Ways;

use App\Services\DesignPatterns\Startegy\PaymentGateway\PaymentInterface;

class CardPayment implements PaymentInterface
{
    public function pay(int $amount)
    {
        return "Paid $amount using Stripe.";
    }
}