<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function details() {
        return $this->hasMany(OrderProduct::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function payments() {
        return $this->hasMany(OrderPaymentTransaction::class);
    }
}
