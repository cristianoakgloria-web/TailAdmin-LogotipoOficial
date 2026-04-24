<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::create(['name' => 'admin', 'label' => 'Administrador']);
        \App\Models\Role::create(['name' => 'vendedor', 'label' => 'Vendedor']);
        \App\Models\Role::create(['name' => 'financeiro', 'label' => 'Financeiro']);
        \App\Models\Role::create(['name' => 'contador', 'label' => 'Contador']);
    }
}
