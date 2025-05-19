<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    // Optional: specify the table name if it doesn't follow Laravel's convention
    protected $table = 'product';

    // Optional: specify fillable fields for mass assignment
    protected $fillable = [
        'userID',
        'productName',
        'productImage',
        'productQuantity',
        'productDetails',
        'productCategory',
    ];


    // Optional: if you don't want timestamps like created_at and updated_at
    // public $timestamps = false;

    // Example relationship: One product has many sizes
    // public function sizes()
    // {
    //     return $this->hasMany(ProductSize::class, 'productID');
    // }
}
