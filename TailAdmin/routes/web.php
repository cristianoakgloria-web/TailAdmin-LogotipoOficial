<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VendasController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\FiscalController;
use App\Http\Controllers\AdminController;

// ==========================================
// ROTA PRINCIPAL
// ==========================================
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ==========================================
// 1º AUTENTICAÇÃO (GUEST - NÃO LOGADO)
// ==========================================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Recuperação de senha
    Route::get('/password/email', [AuthController::class, 'showLinkRequestForm'])->name('password.email');
    Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail']);
    
    Route::get('/password/reset/{token?}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [AuthController::class, 'reset']);
});

// ==========================================
// 2º AUTENTICADOS (AUTH - LOGADO)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // Logout e Perfil
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('password.update');
    
    // ==========================================
    // 3º DASHBOARD E VISÃO GERAL
    // ==========================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');
    Route::get('/info', [DashboardController::class, 'info'])->name('info');
    
    // ==========================================
    // 4º VENDAS E CRM
    // ==========================================
    Route::prefix('vendas')->name('vendas.')->group(function () {
        
        // Gestão de Pipeline
        Route::get('/pipeline', [VendasController::class, 'pipeline'])->name('pipeline');
        Route::post('/pipeline/negociacao', [VendasController::class, 'storeNegociacao'])->name('storeNegociacao');
        Route::patch('/pipeline/{id}/estagio', [VendasController::class, 'updateEstagio'])->name('updateEstagio');
        
        // Base de Conhecimento de Clientes
        Route::get('/clientes', [VendasController::class, 'indexClientes'])->name('clientes');
        Route::get('/clientes/{id}', [VendasController::class, 'showCliente'])->name('clientes.show');
        Route::get('/clientes/{id}/historico', [VendasController::class, 'clienteHistorico'])->name('clientes.historico');
        
        // Automação de pedidos
        Route::post('/pedidos/gerar-proposta', [VendasController::class, 'gerarProposta'])->name('gerarProposta');
        Route::post('/pedidos/{id}/converter', [VendasController::class, 'converterPedido'])->name('converterPedido');
    });
    
    // ==========================================
    // 5º GESTÃO FINANCEIRA
    // ==========================================
    Route::prefix('financeiro')->name('financeiro.')->group(function () {
        
        // Fluxo de Caixa
        Route::get('/dashboard', [FinanceiroController::class, 'dashboard'])->name('dashboard');
        Route::get('/previsoes', [FinanceiroController::class, 'previsoes'])->name('previsoes');
        
        // Tesouraria
        Route::get('/tesouraria/alertas', [FinanceiroController::class, 'alertas'])->name('alertas');
        Route::post('/tesouraria/movimentar', [FinanceiroController::class, 'movimentar'])->name('movimentar');
        
        // Conciliação
        Route::get('/conciliacao', [FinanceiroController::class, 'conciliacao'])->name('conciliacao');
        Route::post('/conciliacao/confirmar', [FinanceiroController::class, 'confirmarConciliacao'])->name('confirmarConciliacao');
    });
    
    // ==========================================
    // 6º FISCAL & CONTABILÍSTICO
    // ==========================================
    Route::prefix('fiscal')->name('fiscal.')->group(function () {
        
        // Exportação
        Route::get('/relatorios', [FiscalController::class, 'relatorios'])->name('relatorios');
        Route::post('/exportar-contabilista', [FiscalController::class, 'exportar'])->name('exportar');
        
        // Arquivo Digital
        Route::get('/arquivo-digital', [FiscalController::class, 'arquivoIndex'])->name('arquivoIndex');
        Route::post('/arquivo-digital/upload', [FiscalController::class, 'upload'])->name('upload');
        Route::get('/arquivo-digital/download/{id}', [FiscalController::class, 'download'])->name('download');
    });
    
    // ==========================================
    // 7º CONFIGURAÇÕES E ADMINISTRAÇÃO (SÓ ADMIN)
    // ==========================================
    Route::middleware('can:admin-only')->prefix('admin')->name('admin.')->group(function () {
        
        // Gestão de Utilizadores
        Route::get('/users', [AdminController::class, 'indexUsers'])->name('users.index');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        
        // Configurações da Empresa
        Route::get('/settings/company', [AdminController::class, 'editCompany'])->name('settings.company');
        Route::patch('/settings/company', [AdminController::class, 'updateCompany'])->name('settings.company.update');
        
        // Auditoria
        Route::get('/audit-logs', [AdminController::class, 'auditLogs'])->name('audit.logs');
        Route::get('/info/admin', [AdminController::class, 'adminInfo'])->name('admin.info');
    });
});