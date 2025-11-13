<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un utilisateur secrétaire
        User::factory()->create([
            'name' => 'Secrétaire PRIMAACADEMIE',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // Créer un admin de test
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@primaacademie.com',
            'password' => bcrypt('admin123'),
        ]);

        // Seeder pour les niveaux de langue
        $this->call([
            NiveauSeeder::class,
        ]);
    }
}
