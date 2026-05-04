<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pedido;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClientes = Cliente::count();
        $totalVendas = Pedido::where('status', 'pago')->sum('valor_total');
        $pedidosPendentes = Pedido::where('status', 'pendente')->count();
        
        // Últimos 5 pedidos para a tabela do dashboard
        $ultimosPedidos = Pedido::with('cliente')->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalClientes', 
            'totalVendas', 
            'pedidosPendentes', 
            'ultimosPedidos'
        ));
    }
}