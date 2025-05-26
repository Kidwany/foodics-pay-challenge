<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_providers')->updateOrInsert(
            ['code' => 'foodics'],
            [
                'name' => 'FoodicsProvider Bank',
                'priority' => 1,
                'supports_incoming' => true,
                'supports_outgoing' => true,
                'is_active' => true,
                'config' => json_encode([
                    'currency' => 'SAR',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
