<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

        // Buscar roles
        $adminRole = Role::where('slug', 'admin')->first();
        $gerenteRole = Role::where('slug', 'gerente')->first();
        $vendedorRole = Role::where('slug', 'vendedor')->first();
        $financeiroRole = Role::where('slug', 'financeiro')->first();
        $fiscalRole = Role::where('slug', 'fiscal')->first();
        $userRole = Role::where('slug', 'user')->first();

        // Array de usuários com sexo
        $usuarios = [
            [
                'nome' => 'Administrador do Sistema',
                'email' => 'admin@logotipooficial.ao',
                'password' => Hash::make('admin123'),
                'sexo' => 'M',
                'cargo' => 'Tesoureiro',
                'role' => $adminRole,
            ],
            [
                'nome' => 'João Silva',
                'email' => 'gerente@logotipooficial.ao',
                'password' => Hash::make('gerente123'),
                'sexo' => 'M',
                'cargo' => 'Gerente',
                'role' => $gerenteRole,
            ],
            [
                'nome' => 'Maria Santos',
                'email' => 'vendedor@logotipooficial.ao',
                'password' => Hash::make('vendedor123'),
                'sexo' => 'F',
                'cargo' => 'Vendedora',
                'role' => $vendedorRole,
            ],
            [
                'nome' => 'Carlos Alberto',
                'email' => 'financeiro@logotipooficial.ao',
                'password' => Hash::make('financeiro123'),
                'sexo' => 'M',
                'cargo' => 'Financeiro',
                'role' => $financeiroRole,
            ],
            [
                'nome' => 'Ana Paula',
                'email' => 'fiscal@logotipooficial.ao',
                'password' => Hash::make('fiscal123'),
                'sexo' => 'F',
                'cargo' => 'Fiscal',
                'role' => $fiscalRole,
            ],
            [
                'nome' => 'Utilizador Teste',
                'email' => 'teste@logotipooficial.ao',
                'password' => Hash::make('teste123'),
                'sexo' => 'M',
                'cargo' => 'Utilizador',
                'role' => $userRole,
            ],
        ];

        // Criar usuários e atribuir roles
        foreach ($usuarios as $dados) {
            $role = $dados['role'];
            unset($dados['role']); // Remove 'role' do array antes de criar
            
            $user = User::updateOrCreate(
                ['email' => $dados['email']],
                $dados
            );
            
            // Sincronizar role
            $user->roles()->sync([$role->id]);
        }

        // Mensagens de sucesso
        $this->command->info('✅ Usuários criados com sucesso!');
        $this->command->info('');
        $this->command->info('📧 Acessos:');
        $this->command->info('   admin@logotipooficial.ao | senha: admin123 (Admin)');
        $this->command->info('   gerente@logotipooficial.ao | senha: gerente123 (Gerente)');
        $this->command->info('   vendedor@logotipooficial.ao | senha: vendedor123 (Vendedora)');
        $this->command->info('   financeiro@logotipooficial.ao | senha: financeiro123 (Financeiro)');
        $this->command->info('   fiscal@logotipooficial.ao | senha: fiscal123 (Fiscal)');
        $this->command->info('   teste@logotipooficial.ao | senha: teste123 (Utilizador)');
        $this->command->info('');
        $this->command->info('📋 Footer do Diário de Caixa:');
        $this->command->info('   Admin: O TESOUREIRO - Administrador do Sistema');
        $this->command->info('   Maria: A TESOUREIRA - Maria Santos');
        $this->command->info('   Ana: A TESOUREIRA - Ana Paula');
    }
}