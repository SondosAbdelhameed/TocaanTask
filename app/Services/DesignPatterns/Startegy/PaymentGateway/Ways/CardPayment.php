<?php

namespace App\Services\DesignPatterns\Startegy\PaymentGateway\Ways;

use App\Services\DesignPatterns\Startegy\PaymentGateway\PaymentInterface;
use Carbon\Carbon;

class CardPayment implements PaymentInterface
{
    public function pay(int $amount)
    {
        // implement card payment logic here using stripe
        $transaction['transaction_id'] = 'card_'.Carbon::now()->format('ymdHis');
        $transaction['status'] = 'success';
        return $transaction;
    }
}