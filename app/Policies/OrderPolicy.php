<?php

namespace App\Policies;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderPaymentTransaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

     /**
     * Determine whether the user can pay the model.
     */
    public function pay(User $user, Order $order): Response
    {
        if(!($user->id === $order->user_id)){
            return Response::deny('You do not own this address.');
        }
        $successTransaction = OrderPaymentTransaction::where('order_id',$order->id)->where('status','success')->first();
        if($successTransaction){
            return Response::deny('This order has already been paid.');
        }
        return Response::allow() ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        $existingOrder = Order::where('user_id',$user->id)->where('status',OrderStatusEnum::PENDING->value)->first();
        if($existingOrder){
            return Response::deny('You have a pending order. Please complete or cancel it before creating a new one.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): Response
    {
        if(!($user->id === $order->user_id)){
            return Response::deny('You do not own this address.');
        }

        if(!($order->payments()->count() == 0)){
            return Response::deny('Only pending orders can be updated.');
        }
        return Response::allow() ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): Response
    {
        if(!($user->id === $order->user_id)){
            return Response::deny('You do not own this address.');
        }

        if($order->payments()->count() > 0 || $order->status != OrderStatusEnum::PENDING->value){
            return Response::deny('Only pending orders can be deleted.');
        }
        return Response::allow() ;
    }

    /**
     * Determine whether the user can cancel the model.
     */
    public function cancel(User $user, Order $order): Response
    {
        if(!($user->id === $order->user_id)){
            return Response::deny('You do not own this address.');
        }

        if($order->status != OrderStatusEnum::CONFIRMED->value){
            return Response::deny('Only confirmed orders can be cancelled.');
        }
        return Response::allow() ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return false;
    }
}
