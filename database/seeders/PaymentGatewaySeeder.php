<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Services\DesignPatterns\Startegy\PaymentGateway\Ways\AliPayPayment;
use App\Services\DesignPatterns\Startegy\PaymentGateway\Ways\CardPayment;
use App\Services\DesignPatterns\Startegy\PaymentGateway\Ways\PayPalPayment;
use App\Services\DesignPatterns\Startegy\PaymentGateway\Ways\WeChatPayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::UpdateOrCreate(
            ['name' => 'Credit Card'],
            ['provider_class' => CardPayment::class]
        );

        PaymentMethod::UpdateOrCreate(
            ['name' => 'PayPal'],
            ['provider_class' => PayPalPayment::class]
        );

        PaymentMethod::UpdateOrCreate(
            ['name' => 'Alipay'],
            ['provider_class' => AliPayPayment::class, 'is_active' => false]
        );

        PaymentMethod::UpdateOrCreate(
            ['name' => 'WeChat'],
            ['provider_class' => WeChatPayment::class, 'is_active' => false]
        );
    }
}
