<?php

namespace App\Services\DesignPatterns\Startegy\PaymentGateway;

use App\Services\DesignPatterns\Startegy\PaymentGateway\PaymentInterface;

class PaymentContext
{
    protected $strategy;

    public function __construct(PaymentInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function executePayment(int $amount)
    {
        return $this->strategy->pay($amount);
    }
}