<?php

namespace App\Http\Controllers;

use App\Models\Pedido;

class FinanceiroController extends Controller
{
    public function index()
    {
        // Lista apenas faturas pagas ou canceladas para controle
        $receitas = Pedido::where('status', 'pago')->paginate(15);
        $totalRecebido = Pedido::where('status', 'pago')->sum('valor_total');

        return view('financeiro.index', compact('receitas', 'totalRecebido'));
    }
}