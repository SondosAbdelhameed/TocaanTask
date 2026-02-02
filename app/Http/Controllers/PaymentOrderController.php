<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\Order\OrderPaymentRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\Order\PaymentMethodResource;
use App\Http\Resources\Order\PaymentTransactionResource;
use App\Http\Resources\SuccessResource;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Services\DesignPatterns\Startegy\PaymentGateway\PaymentContext;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class PaymentOrderController extends Controller
{
    
    public function paymentMethods()
    {
        $payments = PaymentMethod::where('is_active', true)->get();
        return PaymentMethodResource::collection($payments);
    }

    public function payOrder(OrderPaymentRequest $request)
    {

        $order = Order::findOrFail($request->order_id);
        Gate::authorize('pay', $order);

        $paymentMethod = PaymentMethod::where('is_active', true)->findOrFail($request->payment_method_id);
        if (!class_exists($paymentMethod->provider_class)) {
            throw new \Exception("Payment provider class not found.");
        }

        $strategy = app($paymentMethod->provider_class);

        $paymentContext = new PaymentContext($strategy);
        $payment =$paymentContext->executePayment($order->total);
        $service = new OrderService();
        $service->savePaymentTransaction($order, $paymentMethod->id, $payment['transaction_id'], $payment['status']); 
        $order->status = OrderStatusEnum::CONFIRMED->value;
        $order->save();
        if ($payment['status'] === 'success') {
            return new SuccessResource(Response::HTTP_OK,'Payment processed successfully.');
        }else{
            return new ErrorResource(Response::HTTP_BAD_REQUEST,'Payment failed.');
        }
    }

    public function orderPaymentTransaction(string $id)
    {
        $order = Order::with('paymentTransactions')->findOrFail($id);
        Gate::authorize('view', $order);
        return PaymentTransactionResource::collection($order->paymentTransactions); 
    }

   
}
