<?php

namespace App\Services\DesignPatterns\Startegy\PaymentGateway\Ways;

use App\Services\DesignPatterns\Startegy\PaymentGateway\PaymentInterface;

class PayPalPayment implements PaymentInterface
{
    public function pay(int $amount)
    {
        return "Paid $amount using PayPal.";
    }
}