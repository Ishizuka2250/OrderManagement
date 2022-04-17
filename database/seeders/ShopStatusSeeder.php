<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShopStatus;

class ShopStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        ShopStatus::truncate();
        ShopStatus::create([
            'status_name' => 'Close',
            'is_now_status' => true
        ]);
        ShopStatus::create([
            'status_name' => 'Open',
            'is_now_status' => false
        ]);
        ShopStatus::create([
            'status_name' => 'Break',
            'is_now_status' => false
        ]);
    }
}
