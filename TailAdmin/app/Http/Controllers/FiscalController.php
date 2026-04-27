<?php

namespace App\Http\Controllers;

use App\Models\Pedido;

class FiscalController extends Controller
{
    public function index()
    {
        // Agrupa vendas por mês para relatórios fiscais
        $relatorioMensal = Pedido::selectRaw('MONTH(created_at) as mes, SUM(valor_total) as total')
            ->where('status', 'pago')
            ->groupBy('mes')
            ->get();

        return view('fiscal.index', compact('relatorioMensal'));
    }
}