<?php

namespace App\Models;

use App\Policies\OrderPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(OrderPolicy::class)]
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'subtotal',
        'tax',
        'discount',
        'shipping',
        'total',
        'status',
        'cancelled_at',
    ];

    public function scopeFilter($query, $request)
    {
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        return $query;
    }

    public function orderProducts() {
        return $this->hasMany(OrderProduct::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function paymentTransactions() {
        return $this->hasMany(OrderPaymentTransaction::class);
    }
}
