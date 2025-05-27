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
}
