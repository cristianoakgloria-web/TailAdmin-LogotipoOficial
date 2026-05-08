<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nome',
        'sexo',      // NOVO
        'cargo',     // NOVO
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    /**
     * Relacionamento com roles (já existente)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')
                    ->withTimestamps();
    }

    /**
     * Verifica se tem uma role específica (já existente)
     */
    public function hasRole($slug)
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    /**
     * Verifica se é admin (já existente)
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * NOVO: Retorna o título para o footer do Diário de Caixa
     * Ex: "O TESOUREIRO" ou "A TESOUREIRA"
     */
    public function getTituloFooterAttribute(): string
    {
        if ($this->sexo === 'F') {
            return 'A TESOUREIRA';
        }
        return 'O TESOUREIRO';
    }

    /**
     * NOVO: Retorna o nome completo para o footer
     */
    public function getNomeFooterAttribute(): string
    {
        return $this->nome;
    }

    /**
     * NOVO: Retorna o cargo do usuário
     */
    public function getCargoAttribute($value): string
    {
        return $value ?: 'Tesoureiro/a';
    }
}