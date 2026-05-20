<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nome', 'bi', 'nif', 'email', 'telefone'
    ];

    public function servicos()
    {
        return $this->hasMany(\App\Models\Servico::class);
    }

    public function faturas()
    {
        return $this->hasMany(Fatura::class);
    }
}