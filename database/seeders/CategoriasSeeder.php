<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run()
    {
        DB::table('categorias')->insert([
            ['nome' => 'Lanches', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Bebidas', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Porções', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Combos', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}