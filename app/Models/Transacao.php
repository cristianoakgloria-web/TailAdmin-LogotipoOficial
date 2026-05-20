<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    // Importante: especificar o nome da tabela
    protected $table = 'transacaos';
    
    protected $fillable = [
        'arquivo_caixa_id',
        'data_vencimento',
        'tipo',
        'valor',
        'descricao',
        'categoria',
        'observacao',
    ];

    protected $casts = [
        'data_vencimento' => 'date',
        'valor' => 'decimal:2',
    ];
}