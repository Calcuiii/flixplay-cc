<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionPlan::create([
            'name' => 'Free',
            'description' => 'Paket gratis dengan batasan 1x nonton per film',
            'price' => 0,
            'duration_days' => 9999,
            'features' => ['Nonton 1x per film (HD)', 'No Download'],
            'is_active' => true,
        ]);

        SubscriptionPlan::create([
            'name' => 'Premium',
            'description' => 'Paket premium untuk nonton unlimited',
            'price' => 30000,
            'duration_days' => 30,
            'features' => ['Unlimited Watch (Full HD)', '2 Device', 'No Ads'],
            'is_active' => true,
        ]);
    }
}