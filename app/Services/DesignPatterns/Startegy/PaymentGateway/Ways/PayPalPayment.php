<?php

namespace App\Services\DesignPatterns\Startegy\PaymentGateway\Ways;

use App\Services\DesignPatterns\Startegy\PaymentGateway\PaymentInterface;
use Carbon\Carbon;

class PayPalPayment implements PaymentInterface
{
    public function pay(int $amount)
    {
        // implement PayPal payment logic here
        $transaction['transaction_id'] = 'paypal_'.Carbon::now()->format('ymdHis');
        $transaction['status'] = 'success';
        return $transaction;
    }
}