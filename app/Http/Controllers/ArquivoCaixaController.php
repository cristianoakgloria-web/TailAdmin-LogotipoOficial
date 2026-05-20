<?php

namespace App\Http\Controllers;

use App\Models\ArquivoCaixa;
use Illuminate\Http\Request;

class ArquivoCaixaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'mes' => 'required|string',
            'ano' => 'required|integer|min:2000|max:2099',
            'moeda' => 'required|string|max:3',
            'saldo_anterior' => 'nullable|numeric',
            'despesa_anterior' => 'nullable|numeric',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'rascunho';

        ArquivoCaixa::create($validated);

        return redirect()->route('diario-caixa.index')
            ->with('success', '✅ Diário criado com sucesso!');
    }

    public function destroy($id)
    {
        $arquivo = ArquivoCaixa::where('user_id', auth()->id())->findOrFail($id);
        $arquivo->delete();

        return redirect()->route('diario-caixa.index')
            ->with('success', 'Diário excluído com sucesso!');
    }
}