@extends('layouts.app')

@section('title', 'Relatórios Fiscais')
@section('header', 'Fiscal')
@section('subheader', 'Exporte relatórios para a contabilidade')

@section('content')
<div class="max-w-2xl mx-auto animate-fadeUp">
    <div class="bg-gradient-to-b from-[#111114] to-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6 shadow-2xl">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-full bg-[#eab308]/10 flex items-center justify-center">
                <svg class="w-6 h-6 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">Exportar relatório fiscal</h2>
                <p class="text-sm text-zinc-500">Gere ficheiro CSV com as faturas pagas no período</p>
            </div>
        </div>

        <form action="{{ route('fiscal.exportar') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Ano <span class="text-[#eab308]">*</span></label>
                <select name="ano" required class="w-full bg-black border border-gray-700 rounded-lg p-2.5 text-gray-300 focus:border-[#eab308] focus:ring-1 focus:ring-[#eab308] transition">
                    @foreach($anos as $ano)
                        <option value="{{ $ano }}" {{ $ano == date('Y') ? 'selected' : '' }}>{{ $ano }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Mês <span class="text-zinc-500 text-xs">(opcional)</span></label>
                <select name="mes" class="w-full bg-black border border-gray-700 rounded-lg p-2.5 text-gray-300 focus:border-[#eab308] focus:ring-1 focus:ring-[#eab308] transition">
                    <option value="">Todos os meses</option>
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}">{{ str_pad($m,2,'0',STR_PAD_LEFT) }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-zinc-500 mt-1">Se não seleccionar, será gerado o relatório anual completo.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Formato</label>
                <select name="formato" class="w-full bg-black border border-gray-700 rounded-lg p-2.5 text-gray-300 focus:border-[#eab308] transition">
                    <option value="csv">CSV (compatível com Excel)</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-[#eab308]/20">
                <a href="{{ route('fiscal.index') }}" class="px-5 py-2.5 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-gray-300 transition-all duration-300">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-[#eab308] hover:bg-[#d4a007] text-black font-bold transition-all duration-300 shadow-lg hover:scale-[1.02] flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    Exportar relatório
                </button>
            </div>
        </form>
    </div>
</div>
@endsection