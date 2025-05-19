<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSizeModel extends Model
{
    protected $table = 'productsize';

    protected $fillable =[
        'productID',
        'userID',
        'prod_size',
        'prod_model',
        'prod_size'
    ];
}
