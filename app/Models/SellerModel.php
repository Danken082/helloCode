<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerModel extends Model
{
    protected $table = 'regseller';

    // Optional: specify fillable fields for mass assignment
    protected $fillable = [
        'userID',
        'address',
        'bussinessName',
        'productImage',
        'businessAge',
        'shopStatus'
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
    public function product()
    {
        return $this->hasMany(ProductModel::class, 'userID', 'userID');
    }


    

}
