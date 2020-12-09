<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'coupon' => 'FIXED10',
            'min_price' => '50',
            'min_item' => '0',
        ]);

        Coupon::create([
            'coupon' => 'PERCENT10',
            'min_price' => '100',
            'min_item' => '1',
        ]);

        Coupon::create([
            'coupon' => 'MIXED10',
            'min_price' => '200',
            'min_item' => '2',
        ]);

        Coupon::create([
            'coupon' => 'REJECTED10',
            'min_price' => '1000',
            'min_item' => '0',
        ]);
    }
}
