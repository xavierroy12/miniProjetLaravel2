<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Vous pouvez ajouter d’autres "seeders" en les séparant par des virgules.
            CategorieSeeder::class,
            ProduitSeeder::class,
            RoleSeeder::class
            ]);

    }
}
