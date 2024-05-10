<?php

namespace Database\Seeders;

use App\Models\orderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        orderStatus::insert([['status'=>'Pending','color_code'=>'#fff','bg_color_code' => '#F7CB73'],
        ['status'=>'Processing','color_code'=>'#fff','bg_color_code' => '#2DCCFF'],
        ['status'=>'Order Confirmed','color_code'=>'#fff','bg_color_code' => '#93c47d'],
        ['status'=>'Order Shipped','color_code'=>'#fff','bg_color_code' => '#c27ba0'],
        ['status'=>'Out For Delivery','color_code'=>'#fff','bg_color_code' => '#30F558'],
        ['status'=>'Order Delivered','color_code'=>'#fff','bg_color_code' => '#38761D'],
        ['status'=>'Order Cancelled','color_code'=>'#fff', 'bg_color_code' => '#FF3838'],
        ['status'=>'Return','color_code'=>'#fff','bg_color_code' => '#A4ABB6'],
        ['status'=>'Return Pending','color_code'=>'#fff','bg_color_code' => '#FFAF3D'],
        ['status'=>'Refund','color_code'=>'#fff','bg_color_code' => '#e06666'],
        ['status'=>'Order Replaced','color_code'=>'#fff','bg_color_code' => '#085394']
    ]);
    }
}
