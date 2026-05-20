<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    protected $fillable = [
        'cliente_id', 'numero_fatura', 'data_emissao', 'data_vencimento',
        'valor_total', 'status', 'tipo', 'descricao', 'servico_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }

    public function getValorPagoAttribute()
    {
        return $this->pagamentos()->sum('valor');
    }

    public function getSaldoAttribute()
    {
        return $this->valor_total - $this->valor_pago;
    }

    protected $casts = [
        'data_emissao' => 'date',
        'data_vencimento' => 'date',
        'valor_total' => 'decimal:2',
    ];
}