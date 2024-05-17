<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected  $guarded = [];
    public function histories()
    {
        return $this->hasMany(OrderHistory::class);
    }

    public function create(array $attributes = [])
    {
        $order = parent::create($attributes);
        $order->histories()->create([
            'order_id' => $order->id,
            'order_status_id' => $attributes['order_status'],
            'date_time' => $attributes['order_created_date_time'],
        ]);
        return $order;
    }

    public function update(array $attributes = [], array $options = [])
    {
        // update on the order table
        parent::update($attributes, $options);

        // Check if order status or creation date-time changed to avoid unnecessary updates
        if (isset($attributes['order_status']) || isset($attributes['order_created_date_time'])) {

            $order = $this->find($this->id);

            $order->histories()->create([
                'order_id' => $order->id,
                'order_status_id' => (isset($attributes['order_status'])) ? $attributes['order_status'] : $order->order_status_id,
                'date_time' => (isset($attributes['order_created_date_time'])) ? $attributes['order_created_date_time'] : $order->order_created_date_time,
            ]);
        }
    }
}
