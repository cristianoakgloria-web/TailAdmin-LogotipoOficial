@extends('layouts.app')

@section('title', 'Editar Fatura')
@section('header', 'Financeiro')

@section('content')
<div class="max-w-3xl mx-auto animate-fadeUp">
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('faturas.index') }}" class="text-gray-400 hover:text-[#eab308] transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="text-xl font-bold text-white">Editar Fatura {{ $fatura->numero_fatura }}</h2>
        </div>

        <form method="POST" action="{{ route('faturas.update', $fatura) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <x-input-label for="cliente_id" value="Cliente" required />
                <select name="cliente_id" required class="mt-1 w-full rounded-lg border border-[#eab308]/20 bg-black p-3">
                    @foreach($clientes as $c)
                        <option value="{{ $c->id }}" {{ old('cliente_id', $fatura->cliente_id) == $c->id ? 'selected' : '' }}>{{ $c->nome }} (NIF: {{ $c->nif }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div><x-input-label value="Data Emissão" /><input type="date" name="data_emissao" value="{{ old('data_emissao', $fatura->data_emissao->format('Y-m-d')) }}" required class="mt-1 w-full bg-black border border-[#eab308]/20 rounded-lg p-3"></div>
                <div><x-input-label value="Data Vencimento" /><input type="date" name="data_vencimento" value="{{ old('data_vencimento', $fatura->data_vencimento->format('Y-m-d')) }}" required class="mt-1 w-full bg-black border border-[#eab308]/20 rounded-lg p-3"></div>
            </div>

            <div><x-input-label value="Valor Total (Kz)" /><input type="number" step="0.01" name="valor_total" value="{{ old('valor_total', $fatura->valor_total) }}" required class="mt-1 w-full bg-black border border-[#eab308]/20 rounded-lg p-3"></div>

            <div><x-input-label value="Tipo" /><select name="tipo" class="mt-1 w-full bg-black border border-[#eab308]/20 rounded-lg p-3"><option value="servico">Serviço</option><option value="consultoria">Consultoria</option><option value="campanha">Campanha</option><option value="outro">Outro</option></select></div>

            <div><x-input-label value="Descrição" /><textarea name="descricao" rows="3" class="mt-1 w-full bg-black border border-[#eab308]/20 rounded-lg p-3">{{ old('descricao', $fatura->descricao) }}</textarea></div>

            <div><x-input-label value="Status" /><select name="status" class="mt-1 w-full bg-black border border-[#eab308]/20 rounded-lg p-3"><option value="pendente" {{ $fatura->status=='pendente'?'selected':'' }}>Pendente</option><option value="parcial" {{ $fatura->status=='parcial'?'selected':'' }}>Parcial</option><option value="paga" {{ $fatura->status=='paga'?'selected':'' }}>Paga</option><option value="cancelada" {{ $fatura->status=='cancelada'?'selected':'' }}>Cancelada</option></select></div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('faturas.show', $fatura) }}" class="px-4 py-2 bg-zinc-800 rounded-lg">Cancelar</a>
                <button type="submit" class="px-6 py-2 bg-[#eab308] text-black font-bold rounded-lg">Actualizar Fatura</button>
            </div>
        </form>
    </div>
</div>
@endsection