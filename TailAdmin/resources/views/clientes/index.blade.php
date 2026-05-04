{{-- resources/views/clientes/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Clientes')
@section('header', 'Clientes')
@section('subheader', 'Gerencie os clientes da empresa')


@extends('layouts.app')

@section('title', 'Clientes')
@section('header', 'Clientes')
@section('subheader', 'Gestão de clientes')

@section('content')
<div class="space-y-6 animate-fadeUp">
    
    {{-- Cabeçalho com botão --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white">Lista de Clientes</h2>
            <p class="text-sm text-zinc-500 mt-1">Gerencie todos os seus clientes cadastrados</p>
        </div>
        <div>
            <a href="" class="inline-flex items-center gap-2 px-4 py-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Adicionar Cliente
            </a>
        </div>
    </div>

    {{-- Tabela de Clientes --}}
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">ID</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Nome</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Email</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Telefone</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                        <tr class="border-b border-[#eab308]/10 hover:bg-[#eab308]/5 transition">
                            <td class="py-3 px-4 text-sm text-gray-300">{{ $cliente->id }}</td>
                            <td class="py-3 px-4 text-sm text-gray-300">{{ $cliente->nome }}</td>
                            <td class="py-3 px-4 text-sm text-gray-300">{{ $cliente->email }}</td>
                            <td class="py-3 px-4 text-sm text-gray-300">{{ $cliente->telefone ?? '—' }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    {{-- Botão Editar --}}
                                    <a href="" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 rounded-lg transition text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    
                                    {{-- Botão Excluir --}}
                                    <form action="" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-lg transition text-sm font-medium"
                                                onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-16 h-16 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <p class="text-gray-400">Nenhum cliente encontrado</p>
                                    <a href="" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Adicionar primeiro cliente
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginação (se tiver) --}}
    @if(isset($clientes) && method_exists($clientes, 'links'))
        <div class="mt-4">
            {{ $clientes->links() }}
        </div>
    @endif
</div>
@endsection