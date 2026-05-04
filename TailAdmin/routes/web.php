<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VendasController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\FiscalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;

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
        
        Route::get('/index', [VendasController::class, 'index'])->name('index');
        Route::get('/create', [VendasController::class, 'create'])->name('create');
        Route::get('/{id}', [VendasController::class, 'show'])->name('show');
       

        // Gestão de Pipeline
        Route::get('/pipeline', [VendasController::class, 'pipeline'])->name('pipeline');
        Route::post('/pipeline/negociacao', [VendasController::class, 'storeNegociacao'])->name('storeNegociacao');
        Route::patch('/pipeline/{id}/estagio', [VendasController::class, 'updateEstagio'])->name('updateEstagio');
        
       
        // Automação de pedidos
        Route::post('/pedidos/gerar-proposta', [VendasController::class, 'gerarProposta'])->name('gerarProposta');
        Route::post('/pedidos/{id}/converter', [VendasController::class, 'converterPedido'])->name('converterPedido');
    });
    
    // ==========================================
    // 5º GESTÃO FINANCEIRA
    // ==========================================
    Route::prefix('financeiro')->name('financeiro.')->group(function () {
        
        // Fluxo de Caixa
        Route::get('/dashboard', [FinanceiroController::class, 'index'])->name('dashboard');
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
        
        Route::get('/index', [FiscalController::class, 'index'])->name('index');

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
        Route::get('/audit-logs', [AdminController::class, 'indexLogs'])->name('audit-logs');
        Route::get('/info/admin', [AdminController::class, 'adminInfo'])->name('admin.info');
    });

    // ==========================================
    // 8º ROTAS DE CLIENTES (CRUD)
    // ==========================================
    // Rotas para Clientes
    // Gestão de Clientes - CORRETO
    Route::prefix('clientes')->name('clientes.')->group(function () {
        Route::get('/index', [ClienteController::class, 'index'])->name('index');
        Route::get('/create', [ClienteController::class, 'create'])->name('create');
        Route::post('/', [ClienteController::class, 'store'])->name('store');
        Route::get('/{id}', [ClienteController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ClienteController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ClienteController::class, 'update'])->name('update');
        Route::delete('/{id}', [ClienteController::class, 'destroy'])->name('destroy');
    });
});