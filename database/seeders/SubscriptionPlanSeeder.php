<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Mensuel',
                'duration_type' => 'monthly',
                'duration_months' => 1,
                'price' => 300,
                'description' => 'Accès à la salle de sport',
                'features' => ['Accès salle', 'Eau à volonté', 'Application mobile'],
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Premium Trimestriel',
                'duration_type' => 'quarterly',
                'duration_months' => 3,
                'price' => 800,
                'discount_price' => 750,
                'description' => 'Accès complet avec coach',
                'features' => ['Accès salle', 'Coach personnel', 'Programme nutrition', 'Application mobile'],
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'VIP Annuel',
                'duration_type' => 'yearly',
                'duration_months' => 12,
                'price' => 3000,
                'discount_price' => 2500,
                'description' => 'Pack complet VIP',
                'features' => ['Accès 24/7', 'Coach VIP', 'Nutrition personnalisée', 'Espace spa', 'Parking gratuit'],
                'sort_order' => 3,
                'is_active' => true
            ]
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}