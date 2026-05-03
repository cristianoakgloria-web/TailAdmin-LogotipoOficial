<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar roles
        $roles = [
            ['nome' => 'Administrador', 'slug' => 'admin'],
            ['nome' => 'Gerente', 'slug' => 'gerente'],
            ['nome' => 'Vendedor', 'slug' => 'vendedor'],
            ['nome' => 'Financeiro', 'slug' => 'financeiro'],
            ['nome' => 'Fiscal', 'slug' => 'fiscal'],
            ['nome' => 'Utilizador', 'slug' => 'user'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                ['nome' => $role['nome']]
            );
        }

        // Criar usuário admin
        $adminRole = Role::where('slug', 'admin')->first();
        
        $admin = User::updateOrCreate(
            ['email' => 'admin@logotipooficial.ao'],
            [
                'nome' => 'Administrador do Sistema',
                'password' => Hash::make('admin123'),
            ]
        );
        
        // Atribuir role admin (sync sem duplicar)
        $admin->roles()->sync([$adminRole->id]);

        // Criar usuário gerente
        $gerenteRole = Role::where('slug', 'gerente')->first();
        
        $gerente = User::updateOrCreate(
            ['email' => 'gerente@logotipooficial.ao'],
            [
                'nome' => 'João Silva',
                'password' => Hash::make('gerente123'),
            ]
        );
        
        $gerente->roles()->sync([$gerenteRole->id]);

        // Criar usuário vendedor
        $vendedorRole = Role::where('slug', 'vendedor')->first();
        
        $vendedor = User::updateOrCreate(
            ['email' => 'vendedor@logotipooficial.ao'],
            [
                'nome' => 'Maria Santos',
                'password' => Hash::make('vendedor123'),
            ]
        );
        
        $vendedor->roles()->sync([$vendedorRole->id]);

        // Criar usuário financeiro
        $financeiroRole = Role::where('slug', 'financeiro')->first();
        
        $financeiro = User::updateOrCreate(
            ['email' => 'financeiro@logotipooficial.ao'],
            [
                'nome' => 'Carlos Alberto',
                'password' => Hash::make('financeiro123'),
            ]
        );
        
        $financeiro->roles()->sync([$financeiroRole->id]);

        // Criar usuário fiscal
        $fiscalRole = Role::where('slug', 'fiscal')->first();
        
        $fiscal = User::updateOrCreate(
            ['email' => 'fiscal@logotipooficial.ao'],
            [
                'nome' => 'Ana Paula',
                'password' => Hash::make('fiscal123'),
            ]
        );
        
        $fiscal->roles()->sync([$fiscalRole->id]);

        // Criar usuário comum
        $userRole = Role::where('slug', 'user')->first();
        
        $user = User::updateOrCreate(
            ['email' => 'teste@logotipooficial.ao'],
            [
                'nome' => 'Utilizador Teste',
                'password' => Hash::make('teste123'),
            ]
        );
        
        $user->roles()->sync([$userRole->id]);
        
        $this->command->info('✅ Usuários criados com sucesso!');
        $this->command->info('📧 admin@logotipooficial.ao | senha: admin123');
        $this->command->info('📧 teste@logotipooficial.ao | senha: teste123');
    }
}