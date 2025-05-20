<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistoryModel extends Model
{
    protected $table = 'orderhistory';

    protected $fillable = [
        'prod_id',
        'userID',
        'quantity',
        'totalPrice',
        'orderCode',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'prod_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
