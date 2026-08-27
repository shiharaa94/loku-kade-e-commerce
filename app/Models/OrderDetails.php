<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $fillable = [
        'order_number',
        'product_id',
        'stock_id',
        'product_name',
        'cost_price',
        'selling_price',
        'quantity',
        'amount',
        'agent_id',
        'exchange',
        'exchange_reason',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
