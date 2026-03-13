<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SubscriptionPlan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== 1. Créer l'admin =====
        User::firstOrCreate(
            ['email' => 'admin@fitness.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );

        // ===== 2. Créer un utilisateur test =====
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'is_admin' => false,
            ]
        );

        // ===== 3. Appeler TES seeders =====
        $this->call(SubscriptionPlanSeeder::class);
        
        // Message de confirmation
        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('✅ Admin: admin@fitness.com / password');
        $this->command->info('✅ Test: test@example.com / password');
    }
}