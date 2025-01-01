<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilieresTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('filieres')->insert([
            ['name' => 'Informatique', 'description' => 'Développement et systèmes informatiques'],
            ['name' => 'Mathématiques', 'description' => 'Sciences mathématiques'],
            ['name' => 'Physique', 'description' => 'Sciences physiques'],
            ['name' => 'Chimie', 'description' => 'Sciences chimiques'],
            // Ajoutez d'autres filières selon vos besoins
        ]);
    }
}
