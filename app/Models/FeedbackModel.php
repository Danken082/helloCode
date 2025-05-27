<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackModel extends Model
{
    protected $table = 'complainsproductfeedback';

    protected $fillable = [
        'prod_id',
        'userID',
        'comment',
        'complainImage',
        'ratings',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'prod_id');
    }
}
