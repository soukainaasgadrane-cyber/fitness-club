<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Member;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Utilisateurs
        User::create([
            'name' => 'Admin',
            'email' => 'admin@fitness.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Utilisateur',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Membres de test
        $member1 = Member::create([
            'first_name' => 'Ahmed',
            'last_name' => 'Elmaghribi',
            'email' => 'ahmed@example.com',
            'phone' => '0612345678',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'address' => 'Casablanca',
            'is_active' => true,
        ]);

        $member2 = Member::create([
            'first_name' => 'Fatima',
            'last_name' => 'Alaloui',
            'email' => 'fatima@example.com',
            'phone' => '0612345679',
            'birth_date' => '1995-05-15',
            'gender' => 'female',
            'address' => 'Rabat',
            'is_active' => true,
        ]);

        // Abonnements
        Subscription::create([
            'member_id' => $member1->id,
            'plan_type' => 'monthly',
            'price' => 300,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'payment_status' => 'paid',
            'payment_method' => 'cash',
            'is_active' => true,
        ]);

        Subscription::create([
            'member_id' => $member2->id,
            'plan_type' => 'yearly',
            'price' => 3000,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'payment_status' => 'paid',
            'payment_method' => 'card',
            'is_active' => true,
        ]);
    }
}