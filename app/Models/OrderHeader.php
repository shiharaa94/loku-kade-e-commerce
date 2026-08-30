<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHeader extends Model
{
    protected $fillable = [
        'dispatch_date',
        'order_number',
        'tracking_number',
        'total_amount',
        'agent_id',
        'courier_status',
        'payment_type',
        'shipping_type',
        'shipping_cost',
        'customer_name',
        'customer_email',
        'customer_address',
        'customer_city',
        'customer_pri_mobile',
        'customer_sec_mobile',
        'notify',
        'commission',
        'status_type',
        'status_updated_at',
        'secure_token',
        'receipt_number',
        'receipt_image',
        'fulfillment_type',
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->secure_token)) {
                $order->secure_token = \Illuminate\Support\Str::random(32);
            }
        });

        static::updated(function ($order) {
            if ($order->isDirty('courier_status') && strtolower($order->courier_status) === 'delivered') {
                if ($order->customer_email) {
                    try {
                        \Illuminate\Support\Facades\Mail::to($order->customer_email)
                            ->send(new \App\Mail\OrderDeliveredReviewMail($order));
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Failed to send review request email for order {$order->order_number}: " . $e->getMessage());
                    }
                }
            }
        });
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_number', 'order_number');
    }
}
