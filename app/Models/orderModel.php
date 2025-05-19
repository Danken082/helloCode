<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orderModel extends Model
{
    protected $table = 'order_table';

    protected $fillable = [
        'prod_id',
        'userID',
        'quantity',
        'totalPrice',
        'orderCode',
        'status'
    ];
}
