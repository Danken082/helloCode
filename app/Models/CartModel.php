<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'prod_id',
        'userID',
        'quantity',
        'prod_size',
        'totalPrice',
    ];
}
