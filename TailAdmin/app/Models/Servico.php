<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = 'servicos';
    
    protected $fillable = [
        'cliente_id', 'titulo', 'descricao', 'valor', 'status',
        'data_prevista', 'data_inicio', 'data_fim',
        'responsavel_id', 'observacoes'
    ];

    protected $casts = [
        'data_prevista' => 'date',
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'valor' => 'decimal:2'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
    
    // Accessor para status formatado
    public function getStatusLabelAttribute()
    {
        $labels = [
            'proposta' => 'Proposta',
            'negociacao' => 'Negociação',
            'contratado' => 'Contratado',
            'em_andamento' => 'Em Andamento',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado'
        ];
        
        return $labels[$this->status] ?? $this->status;
    }
    
    // Accessor para cor do status
    public function getStatusColorAttribute()
    {
        $colors = [
            'proposta' => 'blue',
            'negociacao' => 'purple',
            'contratado' => 'green',
            'em_andamento' => 'yellow',
            'concluido' => 'emerald',
            'cancelado' => 'red'
        ];
        
        return $colors[$this->status] ?? 'gray';
    }

    public function faturas()
    {
        return $this->hasMany(Fatura::class);
    }
}