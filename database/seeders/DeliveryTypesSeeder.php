<?php

namespace Database\Seeders;

use App\Models\DeliveryTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryTypesseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryTypes::insert([['types'=>'Standard'],['types'=>'Express'],['types'=>'Oneday']]);
    }
}
