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
            'date_time' => now(),
        ]);
        return $order;
    }

    public function updateStatus(array $attributes = [])
    {
        $originalOrder = $this->where('id', $this->id)->first();
        $updated = $this->update($attributes);

        // Check if relevant attributes changed and create history
        if (($updated && isset($attributes['order_status']) && $originalOrder->order_status !== $attributes['order_status']) ||
            ($updated && isset($attributes['order_created_date_time']) && $originalOrder->order_created_date_time !== $attributes['order_created_date_time'])
        ) {
            $orderHistoryData = [
                'order_id' => $originalOrder->id,
                'order_status_id' => (isset($attributes['order_status'])) ? $attributes['order_status'] : $originalOrder->order_status,
                'date_time' => now(),
            ];

            $originalOrder->histories()->create($orderHistoryData);
        }

        return $updated;
    }
}
