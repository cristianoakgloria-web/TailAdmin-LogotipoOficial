<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VendasController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\FiscalController;
use App\Http\Controllers\AdminController;

// 1º Autenticação e Perfil
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/password/email', [AuthController::class, 'showLinkRequestForm'])->name('password.email');
    Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail']);
    
    Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [AuthController::class, 'reset']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); //[cite: 27]
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile'); //[cite: 27]

    //2º Dashboard e Visão Geral
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [DashboardController::class, 'notifications']);
    Route::get('/info', [DashboardController::class, 'info']);

    // 3º Vendas e CRM [cite: 28]
    Route::prefix('vendas')->group(function () {
        // Gestão de Pipeline [cite: 28]
        Route::get('/pipeline', [VendasController::class, 'pipeline']);
        Route::post('/pipeline/negociacao', [VendasController::class, 'storeNegociacao']);
        Route::patch('/pipeline/{id}/estagio', [VendasController::class, 'updateEstagio']);

        // Base de Conhecimento de Clientes [cite: 28, 29]
        Route::get('/clientes', [VendasController::class, 'indexClientes']);
        Route::get('/clientes/{id}', [VendasController::class, 'showCliente']);
        Route::get('/clientes/{id}/historico', [VendasController::class, 'clienteHistorico']);

        // Automação de pedidos [cite: 29]
        Route::post('/pedidos/gerar-proposta', [VendasController::class, 'gerarProposta']);
        Route::post('/pedidos/{id}/converter', [VendasController::class, 'converterPedido']);
    });

    //4º Gestão Financeira [cite: 30]
    Route::prefix('financeiro')->group(function () {
        // Fluxo de Caixa [cite: 30]
        Route::get('/dashboard', [FinanceiroController::class, 'dashboard']);
        Route::get('/previsoes', [FinanceiroController::class, 'previsoes']);

        // Tesouraria [cite: 30, 31]
        Route::get('/tesouraria/alertas', [FinanceiroController::class, 'alertas']);
        休Route::post('/tesouraria/movimentar', [FinanceiroController::class, 'movimentar']);

        // Conciliação [cite: 31]
        Route::get('/conciliacao', [FinanceiroController::class, 'conciliacao']);
        Route::post('/conciliacao/confirmar', [FinanceiroController::class, 'confirmarConciliacao']);
    });

    //5º Fiscal & Contabilístico [cite: 31, 32]
    Route::prefix('fiscal')->group(function () {
        // Exportação [cite: 31, 32]
        Route::get('/relatorios', [FiscalController::class, 'relatorios']);
        Route::post('/exportar-contabilista', [FiscalController::class, 'exportar']);

        // Arquivo Digital [cite: 32]
        Route::get('/arquivo-digital', [FiscalController::class, 'arquivoIndex']);
        Route::post('/arquivo-digital/upload', [FiscalController::class, 'upload']);
        Route::get('/arquivo-digital/download/{id}', [FiscalController::class, 'download']);
    });

    // 6º Configurações e Administração
    Route::middleware('can:admin-only')->group(function () {
        Route::get('/users', [AdminController::class, 'indexUsers']);
        Route::post('/users', [AdminController::class, 'storeUser']);
        
        Route::get('/settings/company', [AdminController::class, 'editCompany']);
        Route::patch('/settings/company', [AdminController::class, 'updateCompany']);
        
        Route::get('/audit-logs', [AdminController::class, 'auditLogs']);
        Route::get('/info/admin', [AdminController::class, 'adminInfo']);
    });
});