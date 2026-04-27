<?php

namespace App\Http\Controllers;

use App\Models\Pedido;

class VendasController extends Controller
{
    public function index()
    {
        // Exibe o histórico geral de vendas
        $vendas = Pedido::with('cliente')->latest()->paginate(10);
        return view('vendas.index', compact('vendas'));
    }
}