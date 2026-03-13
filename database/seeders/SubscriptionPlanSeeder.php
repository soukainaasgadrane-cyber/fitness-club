<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Exécute le seeder pour remplir la table subscription_plans avec des données initiales.
     */
    public function run(): void
    {
        // Tableau contenant tous les plans d'abonnement à insérer
        $plans = [
            // === PLAN DE BASE (BASIQUE) ===
            [
                'name' => 'Basique',                    // Nom du plan en français
                'duration_type' => 'monthly',            // Type: mensuel
                'duration_months' => 1,                  // Durée: 1 mois
                'price' => 300.00,                        // Prix: 300 MAD
                'description' => 'Abonnement mensuel adapté aux débutants',
                'features' => json_encode([               // Avantages (en JSON)
                    'Accès à la salle aux heures normales',
                    'Utilisation de tous les équipements',
                    'Consultation une fois par mois'
                ]),
                'is_active' => true,                      // Plan actif
            ],
            [
                'name' => 'Basique',
                'duration_type' => 'quarterly',           // Trimestriel
                'duration_months' => 3,                   // 3 mois
                'price' => 800.00,                         // 800 MAD (économie de 100 MAD)
                'description' => 'Abonnement trimestriel avec 10% de réduction',
                'features' => json_encode([
                    'Accès à la salle aux heures normales',
                    'Utilisation de tous les équipements',
                    'Consultation deux fois par mois'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Basique',
                'duration_type' => 'yearly',              // Annuel
                'duration_months' => 12,                  // 12 mois
                'price' => 2800.00,                        // 2800 MAD (économie de 800 MAD)
                'description' => 'Abonnement annuel avec 22% de réduction',
                'features' => json_encode([
                    'Accès à la salle à toutes les heures',
                    'Utilisation de tous les équipements',
                    'Consultation hebdomadaire',
                    'Séance coaching personnel une fois par mois'
                ]),
                'is_active' => true,
            ],

            // === PLAN VIP ===
            [
                'name' => 'VIP',
                'duration_type' => 'monthly',
                'duration_months' => 1,
                'price' => 600.00,
                'description' => 'Abonnement VIP mensuel',
                'features' => json_encode([
                    'Accès à la salle à toutes les heures',
                    'Utilisation de tous les équipements',
                    'Coach personnel dédié',
                    'Cours collectifs illimités',
                    'Place de parking'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'VIP',
                'duration_type' => 'yearly',
                'duration_months' => 12,
                'price' => 6000.00,
                'description' => 'Abonnement VIP annuel',
                'features' => json_encode([
                    'Accès à la salle à toutes les heures',
                    'Utilisation de tous les équipements',
                    'Coach personnel dédié',
                    'Cours collectifs illimités',
                    'Place de parking',
                    'Hammam marocain hebdomadaire',
                    'Nutrition sportive'
                ]),
                'is_active' => true,
            ],
        ];

        // Insère chaque plan dans la base de données
        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }

        // Message de confirmation (optionnel)
        $this->command->info('✅ Plans d\'abonnement créés avec succès !');
    }
}