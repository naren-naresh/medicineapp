<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Zone_Groups_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('zone_groups')->insert([
        ['name'=>'North Zone'],
        ['name'=>'South Zone'],
        ['name'=>'East Zone'],
        ['name'=>'West Zone'],
        ['name'=>'NorthEast Zone'],
        ['name'=>'NorthWest Zone'],
        ['name'=>'SouthEast Zone'],
        ['name'=>'SothWest Zone']]);
    }
}
