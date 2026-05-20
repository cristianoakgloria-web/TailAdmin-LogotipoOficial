<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoFiscal extends Model
{
    protected $fillable = [
        'fatura_id', 'titulo', 'tipo', 'caminho', 'nome_original', 'valor', 'data_documento', 'user_id'
    ];

    protected $casts = [
        'data_documento' => 'date',
        'valor' => 'decimal:2'
    ];

    public function fatura()
    {
        return $this->belongsTo(Fatura::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}