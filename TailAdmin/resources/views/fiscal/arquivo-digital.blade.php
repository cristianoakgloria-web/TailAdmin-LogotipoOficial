@extends('layouts.app')

@section('title', 'Arquivo Digital')
@section('header', 'Fiscal')
@section('subheader', 'Gestão de documentos fiscais')

@section('content')
<div class="space-y-6 animate-fadeUp">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-[#eab308]/10 border border-[#eab308]/40 text-[#eab308] text-sm flex items-center gap-2">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/40 text-red-400 text-sm flex items-center gap-2">
            <span>⚠️</span> {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-white">Documentos fiscais</h2>
            <p class="text-sm text-zinc-500 mt-1">Armazene faturas, recibos e declarações</p>
        </div>
        <button onclick="document.getElementById('modalUpload').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold px-5 py-2.5 rounded-lg transition-all duration-300 shadow-lg hover:scale-[1.02]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Novo Documento
        </button>
    </div>

    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                    <tr>
                        <th class="p-4 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Título</th>
                        <th class="p-4 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Tipo</th>
                        <th class="p-4 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Data Documento</th>
                        <th class="p-4 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Valor (Kz)</th>
                        <th class="p-4 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentos as $doc)
                    <tr class="border-b border-[#eab308]/10 hover:bg-[#eab308]/5 transition group">
                        <td class="p-4 text-gray-300 font-medium">{{ $doc->titulo }}</td>
                        <td class="p-4 text-gray-400">
                            <span class="px-2 py-1 rounded-full text-xs bg-gray-700/50">{{ $doc->tipo }}</span>
                        </td>
                        <td class="p-4 text-gray-300">
                            @if($doc->data_documento)
                                {{ $doc->data_documento instanceof \Carbon\Carbon ? $doc->data_documento->format('d/m/Y') : \Carbon\Carbon::parse($doc->data_documento)->format('d/m/Y') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="p-4 text-gray-300">{{ $doc->valor ? 'Kz '.number_format($doc->valor,2) : '—' }}</td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="{{ route('fiscal.download', $doc->id) }}" class="p-2 rounded-lg bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 transition" title="Descarregar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </a>
                                <form action="{{ route('fiscal.documentos.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Excluir documento permanentemente?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-400 transition" title="Excluir">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-16 h-16 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-400">Nenhum documento carregado.</p>
                                <p class="text-sm text-zinc-500">Clique em "Novo Documento" para adicionar o primeiro.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(method_exists($documentos, 'links'))
        <div class="mt-4">
            {{ $documentos->links() }}
        </div>
    @endif
</div>

<!-- Modal de upload (desactivado temporariamente – mas mantemos a estrutura) -->
<div id="modalUpload" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl w-full max-w-md p-6 shadow-2xl animate-fadeUp">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-white">Carregar Documento</h3>
            <button onclick="fecharModalUpload()" class="text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <p class="text-gray-400 mb-6">A funcionalidade de upload será activada em breve. Por favor, aguarde a próxima actualização.</p>
        <button onclick="fecharModalUpload()" class="w-full px-4 py-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold rounded-lg transition">Fechar</button>
    </div>
</div>

<script>
function fecharModalUpload() {
    document.getElementById('modalUpload').classList.add('hidden');
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') fecharModalUpload();
});
</script>
@endsection