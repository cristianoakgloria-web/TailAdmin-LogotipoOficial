<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArquivoCaixa extends Model
{
    protected $fillable = [
        'user_id',
        'nome',
        'mes',
        'ano',
        'moeda',
        'saldo_anterior',
        'despesa_anterior',
        'arquivo_path',
        'status',
    ];

    protected $casts = [
        'saldo_anterior' => 'decimal:2',
        'despesa_anterior' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /*
    public function transacoes()
    {
        return $this->hasMany(Transacao::class, 'arquivo_caixa_id');
    }
    */

    public function transacoes() {
        return $this->hasMany(Transacao::class);
    }
}