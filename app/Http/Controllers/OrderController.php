<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\SuccessResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::filter($request)->with('orderProducts')->where('user_id', $request->user()->id)->paginate();
        return OrderResource::collection($orders);
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
    public function store(OrderRequest $request)
    {
        Gate::authorize('create',Order::class);

        try{
            $service = new OrderService();
            $service->saveOrder($request);
            return new SuccessResource(Response::HTTP_OK,"Order created successfully.");
        } catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST,null,$ex->getTrace());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('orderProducts')->findOrFail($id);
        return new OrderResource($order);
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
        /*$order = Order::findOrFail($id);
        Gate::authorize('update', $order);
        */
    }

    public function cancelOrder($orderId)
    {

        $order = Order::findOrFail($orderId);
        Gate::authorize('cancel', $order);
        try {
            $order->status = 'cancelled';
            $order->cancelled_at = now();
            $order->save();
            return new SuccessResource(Response::HTTP_OK,"Order cancelled successfully.");
        } catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST,null,$ex->getTrace());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        Gate::authorize('delete', $order);
        try {
            OrderProduct::where('order_id', $id)->delete();
            $order->delete();
            return new SuccessResource(Response::HTTP_OK,"Order deleted successfully.");
        } catch (\Exception $ex) {
            return new ErrorResource(Response::HTTP_BAD_REQUEST,null,$ex->getTrace());
        }
    }
}
