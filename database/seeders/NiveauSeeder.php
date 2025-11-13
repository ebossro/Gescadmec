<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Niveau;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux = [
            [
                'code' => 'A1',
                'libelle' => 'Débutant A1',
                'prix' => 150000.00,
                'duree_jours' => 90,
                'description' => 'Niveau débutant - Comprendre et utiliser des expressions familières et quotidiennes',
                'actif' => true,
            ],
            [
                'code' => 'A2',
                'libelle' => 'Élémentaire A2',
                'prix' => 175000.00,
                'duree_jours' => 90,
                'description' => 'Niveau élémentaire - Communiquer lors de tâches simples et habituelles',
                'actif' => true,
            ],
            [
                'code' => 'B1',
                'libelle' => 'Intermédiaire B1',
                'prix' => 200000.00,
                'duree_jours' => 120,
                'description' => 'Niveau intermédiaire - Comprendre les points essentiels sur des sujets familiers',
                'actif' => true,
            ],
            [
                'code' => 'B2',
                'libelle' => 'Intermédiaire avancé B2',
                'prix' => 225000.00,
                'duree_jours' => 120,
                'description' => 'Niveau intermédiaire avancé - Comprendre le contenu essentiel de sujets concrets ou abstraits',
                'actif' => true,
            ],
            [
                'code' => 'C1',
                'libelle' => 'Avancé C1',
                'prix' => 250000.00,
                'duree_jours' => 150,
                'description' => 'Niveau avancé - Comprendre une grande gamme de textes longs et exigeants',
                'actif' => true,
            ],
            [
                'code' => 'C2',
                'libelle' => 'Maîtrise C2',
                'prix' => 300000.00,
                'duree_jours' => 180,
                'description' => 'Niveau maîtrise - Comprendre sans effort pratiquement tout ce qui est lu ou entendu',
                'actif' => true,
            ],
        ];

        foreach ($niveaux as $niveau) {
            Niveau::create($niveau);
        }
    }
}
