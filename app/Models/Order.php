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
}
