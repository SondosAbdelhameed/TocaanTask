<?php

namespace App\Services\DesignPatterns\Startegy\PaymentGateway;

interface PaymentInterface
{
    public function pay(int $amount);
}