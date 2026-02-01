<?php

namespace App\Services\Order;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

class OrderService
{
    public function saveOrder($request)  {
        $order = new Order();
        $order->user_id = $request->user()->id;
        $order->subtotal = 0;
        $order->tax = $request->tax;
        $order->discount = 0;
        $order->shipping = 0;
        $order->total = 0;
        $order->status = OrderStatusEnum::PENDING->value;
        $order->save();

        $subtotal = 0;
        foreach ($request->products as $product) {
            $subtotal += $this->addOrderProduct($product->product_id, $product->quantity, $order->id);
        }

        $order->subtotal = $subtotal;
        $order->total = $subtotal;;
        $order->save();
    }

    public function addOrderProduct($productId,$quantity,$orderId)  {
        $product = Product::findOrFail($productId);
        $orderProduct = new OrderProduct();
        $orderProduct->product_id = $product->id;
        $orderProduct->quantity = $quantity;
        $orderProduct->price = $product->price;
        $orderProduct->order_id = $orderId;
        $orderProduct->save();

        return $quantity * $product->price;
    }

    public function updateOrderProduct($orderProductId, $quantity) {
        $orderProduct = OrderProduct::find($orderProductId);
        $this->calculateOrderdifference($orderProduct, $quantity);
        $orderProduct->update(['quantity' => $quantity]);
    }

    public function deleteOrderProduct($orderProductId) {
        $orderProduct = OrderProduct::find($orderProductId);
        $this->calculateOrderdifference($orderProduct, 0);
        $orderProduct->delete();
    }

    public function calculateOrderdifference($orderProduct, $quantity) {
        $oldPrice = $orderProduct->price * $orderProduct->quantity;
        $newPrice = $orderProduct->price * $quantity;
        $difference = $newPrice - $oldPrice;
        $order = Order::find($orderProduct->order_id);
        $order->subtotal += $difference;
        $order->total += $difference;
        $order->save();
    }

    public function calculateOrderTotal($orderId) {
        $order = Order::find($orderId);
        $subtotal = 0;
        $orderProducts = OrderProduct::where('order_id', $orderId)->get();
        foreach ($orderProducts as $orderProduct) {
            $subtotal += $orderProduct->price * $orderProduct->quantity;
        }
        $order->subtotal = $subtotal;
        $order->total = $subtotal;
        $order->save();
    }
}