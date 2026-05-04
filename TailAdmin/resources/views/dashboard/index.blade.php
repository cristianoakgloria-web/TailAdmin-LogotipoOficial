{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('subheader', 'Visão geral do sistema')

@section('content')
<div class="space-y-8 animate-fadeUp">
    
    {{-- Cards de Estatísticas em Kwanza --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card: Total de Vendas --}}
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6 transition-all hover:border-[#eab308]/40 hover:transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-full bg-[#eab308]/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-green-500 text-sm font-semibold bg-green-500/10 px-2 py-1 rounded-lg">↑ 23%</span>
            </div>
            <h3 class="text-zinc-500 text-sm uppercase tracking-wider mb-1">VENDAS TOTAIS</h3>
            <p class="text-3xl font-bold text-white">KZ 124.589</p>
            <p class="text-zinc-600 text-xs mt-2">Este mês</p>
        </div>

        {{-- Card: Clientes --}}
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6 transition-all hover:border-[#eab308]/40 hover:transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-full bg-[#eab308]/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span class="text-green-500 text-sm font-semibold bg-green-500/10 px-2 py-1 rounded-lg">↑ 12%</span>
            </div>
            <h3 class="text-zinc-500 text-sm uppercase tracking-wider mb-1">CLIENTES ATIVOS</h3>
            <p class="text-3xl font-bold text-white">1.284</p>
            <p class="text-zinc-600 text-xs mt-2">+32 este mês</p>
        </div>

        {{-- Card: Faturas Pendentes --}}
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6 transition-all hover:border-[#eab308]/40 hover:transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-full bg-red-500/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-red-500 text-sm font-semibold bg-red-500/10 px-2 py-1 rounded-lg">⚠️ Urgente</span>
            </div>
            <h3 class="text-zinc-500 text-sm uppercase tracking-wider mb-1">FATURAS PENDENTES</h3>
            <p class="text-3xl font-bold text-white">KZ 45.230</p>
            <p class="text-zinc-600 text-xs mt-2">12 faturas em atraso</p>
        </div>

        {{-- Card: Produtos em Estoque --}}
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6 transition-all hover:border-[#eab308]/40 hover:transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-full bg-[#eab308]/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <span class="text-yellow-500 text-sm font-semibold bg-yellow-500/10 px-2 py-1 rounded-lg">⚠️ Baixo</span>
            </div>
            <h3 class="text-zinc-500 text-sm uppercase tracking-wider mb-1">ESTOQUE ATUAL</h3>
            <p class="text-3xl font-bold text-white">3.421</p>
            <p class="text-zinc-600 text-xs mt-2">unidades em estoque</p>
        </div>
    </div>

    {{-- Gráfico e Atividades Recentes --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Gráfico de Vendas --}}
        <div class="lg:col-span-2 bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-white">Vendas mensais</h3>
                <select class="bg-[#0a0a0c] border border-[#eab308]/30 rounded-lg px-3 py-1 text-sm text-gray-300 focus:outline-none focus:border-[#eab308]">
                    <option>Últimos 30 dias</option>
                    <option>Últimos 90 dias</option>
                    <option>Este ano</option>
                </select>
            </div>
            
            {{-- Gráfico simples com barras --}}
            <div class="h-64 flex items-end space-x-2">
                @php
                    $data = [65, 45, 78, 90, 85, 70, 95, 88, 72, 68, 82, 78];
                    $max = max($data);
                @endphp
                @foreach($data as $value)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-[#eab308]/20 rounded-t-lg transition-all hover:bg-[#eab308]/40" 
                             style="height: {{ ($value / $max) * 200 }}px"></div>
                        <span class="text-xs text-zinc-500 mt-2">{{ $loop->iteration }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between mt-4 text-xs text-zinc-500">
                <span>Jan</span><span>Fev</span><span>Mar</span><span>Abr</span><span>Mai</span><span>Jun</span>
                <span>Jul</span><span>Ago</span><span>Set</span><span>Out</span><span>Nov</span><span>Dez</span>
            </div>
        </div>

        {{-- Atividades Recentes --}}
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
            <h3 class="text-lg font-bold text-white mb-4">Atividades recentes</h3>
            <div class="space-y-4">
                <div class="flex items-start gap-3 pb-3 border-b border-[#eab308]/10">
                    <div class="w-8 h-8 rounded-full bg-green-500/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-300">Nova venda registrada</p>
                        <p class="text-xs text-zinc-500">Cliente: Empresa ABC - KZ 5.400</p>
                        <p class="text-xs text-zinc-600 mt-1">Há 5 minutos</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 pb-3 border-b border-[#eab308]/10">
                    <div class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-300">Novo cliente cadastrado</p>
                        <p class="text-xs text-zinc-500">Maria Silva - Contacto via WhatsApp</p>
                        <p class="text-xs text-zinc-600 mt-1">Há 1 hora</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 pb-3 border-b border-[#eab308]/10">
                    <div class="w-8 h-8 rounded-full bg-yellow-500/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-300">Fatura vence hoje</p>
                        <p class="text-xs text-zinc-500">Empresa XYZ - KZ 12.500</p>
                        <p class="text-xs text-zinc-600 mt-1">Há 2 horas</p>
                    </div>
                </div>
            </div>
            
            <a href="#" class="block text-center mt-4 text-[#eab308] hover:text-[#facc15] text-sm font-semibold transition">
                Ver todas as actividades →
            </a>
        </div>
    </div>

    {{-- Tabela de Últimos Pedidos --}}
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-white">Últimos pedidos</h3>
            <a href="#" class="text-[#eab308] hover:text-[#facc15] text-sm font-semibold transition">Ver todos</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[#eab308]/20">
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Pedido</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Cliente</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Valor (KZ)</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Status</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Data</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-[#eab308]/10 hover:bg-[#eab308]/5 transition">
                        <td class="py-3 px-4 text-sm text-gray-300">#12458</td>
                        <td class="py-3 px-4 text-sm text-gray-300">João Santos</td>
                        <td class="py-3 px-4 text-sm text-gray-300">2.500</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-500">Pago</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-zinc-500">02/05/2026</td>
                    </tr>
                    <tr class="border-b border-[#eab308]/10 hover:bg-[#eab308]/5 transition">
                        <td class="py-3 px-4 text-sm text-gray-300">#12457</td>
                        <td class="py-3 px-4 text-sm text-gray-300">Maria Oliveira</td>
                        <td class="py-3 px-4 text-sm text-gray-300">5.800</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-500">Pendente</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-zinc-500">01/05/2026</td>
                    </tr>
                    <tr class="border-b border-[#eab308]/10 hover:bg-[#eab308]/5 transition">
                        <td class="py-3 px-4 text-sm text-gray-300">#12456</td>
                        <td class="py-3 px-4 text-sm text-gray-300">Carlos Pereira</td>
                        <td class="py-3 px-4 text-sm text-gray-300">12.300</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-500">Pago</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-zinc-500">30/04/2026</td>
                    </tr>
                    <tr class="border-b border-[#eab308]/10 hover:bg-[#eab308]/5 transition">
                        <td class="py-3 px-4 text-sm text-gray-300">#12455</td>
                        <td class="py-3 px-4 text-sm text-gray-300">Ana Costa</td>
                        <td class="py-3 px-4 text-sm text-gray-300">890</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-500">Cancelado</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-zinc-500">28/04/2026</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ações Rápidas --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="#" class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-4 text-center hover:border-[#eab308]/40 transition group">
            <div class="w-10 h-10 mx-auto rounded-full bg-[#eab308]/10 flex items-center justify-center mb-2 group-hover:bg-[#eab308]/20 transition">
                <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-300">Novo pedido</span>
        </a>
        
        <a href="{{ route('clientes.create') }}" class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-4 text-center hover:border-[#eab308]/40 transition group">
            <div class="w-10 h-10 mx-auto rounded-full bg-[#eab308]/10 flex items-center justify-center mb-2 group-hover:bg-[#eab308]/20 transition">
                <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-300">Novo cliente</span>
        </a>
        
        <a href="#" class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-4 text-center hover:border-[#eab308]/40 transition group">
            <div class="w-10 h-10 mx-auto rounded-full bg-[#eab308]/10 flex items-center justify-center mb-2 group-hover:bg-[#eab308]/20 transition">
                <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-300">Relatórios</span>
        </a>
        
        <a href="#" class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-4 text-center hover:border-[#eab308]/40 transition group">
            <div class="w-10 h-10 mx-auto rounded-full bg-[#eab308]/10 flex items-center justify-center mb-2 group-hover:bg-[#eab308]/20 transition">
                <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-300">Configurações</span>
        </a>
    </div>
</div>
@endsection