<?php

namespace App\Services\DesignPatterns\Startegy\PaymentGateway\Ways;

use App\Services\DesignPatterns\Startegy\PaymentGateway\PaymentInterface;

class WeChatPayment implements PaymentInterface
{
    public function pay(int $amount)
    {
        return "Paid $amount using WeChat.";
    }
}