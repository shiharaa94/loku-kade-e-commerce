<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'product_id',
        'cost_price',
        'selling_price',
        'discount',
        'quantity',
        'user_id',
        'dis_status'
    ];
}
