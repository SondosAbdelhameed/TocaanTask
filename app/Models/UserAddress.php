<?php

namespace App\Models;

use App\Policies\UserAddressPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(UserAddressPolicy::class)]
class UserAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'city',
        'full_address',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
