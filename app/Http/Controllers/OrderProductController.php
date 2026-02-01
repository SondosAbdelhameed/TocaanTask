<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\Order\OrderDetailResource;
use App\Http\Resources\SuccessResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\Order\OrderService;
use Error;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class OrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $orderProducts = OrderProduct::where('order_id', $request->order_id)->paginate();
        Gate::authorize('view', $order);   
        return OrderDetailResource::collection($orderProducts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        Gate::authorize('update', $order);
        $service = new OrderService();
        $service->addOrderProduct($request->product_id, $request->quantity, $request->order_id);
        return new SuccessResource(Response::HTTP_OK,"Product added to order successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $orderProduct = OrderProduct::findOrFail($id);
        $order = Order::findOrFail($orderProduct->order_id);
        Gate::authorize('update', $order);
        $service = new OrderService();
        $service->updateOrderProduct($id, $request->quantity);
        return new SuccessResource(Response::HTTP_OK,"Product updated in order successfully.");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $orderProduct = OrderProduct::findOrFail($id);
        $order = Order::with('details')->findOrFail($orderProduct->order_id);
        Gate::authorize('update', $order);
        if ($order->details->count() == 0) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST,"Cannot delete the last product from order.");
        }
        $service = new OrderService();
        $service->deleteOrderProduct($id);
        return new SuccessResource(Response::HTTP_OK,"Product deleted from order successfully.");
    }
}
