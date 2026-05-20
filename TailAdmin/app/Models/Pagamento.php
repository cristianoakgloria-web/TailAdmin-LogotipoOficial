<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $fillable = [
        'fatura_id', 'valor', 'data_pagamento', 'metodo',
        'referencia', 'observacoes', 'user_id'
    ];

    public function fatura()
    {
        return $this->belongsTo(Fatura::class);
    }
}