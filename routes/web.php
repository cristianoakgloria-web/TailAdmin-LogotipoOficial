<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VendasController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\FiscalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DiarioCaixaController;
use App\Http\Controllers\ArquivoCaixaController;
use App\Http\Controllers\FaturaController;
use App\Http\Controllers\PagamentoController;

use App\Http\Controllers\ProfileController;

// ==========================================
// ROTAS DO DIÁRIO DE CAIXA
// ==========================================
Route::middleware(['auth'])->prefix('diario-caixa')->name('diario-caixa.')->group(function () {
    Route::get('/', [DiarioCaixaController::class, 'index'])->name('index');
    Route::post('/', [DiarioCaixaController::class, 'store'])->name('store');
    Route::delete('/{id}', [DiarioCaixaController::class, 'destroy'])->name('destroy');
    Route::post('/preview', [DiarioCaixaController::class, 'preview'])->name('preview');
    Route::match(['GET', 'POST'], '/exportar', [DiarioCaixaController::class, 'exportar'])->name('exportar');
    
    // Gestão de Arquivos
    Route::post('/arquivos', [ArquivoCaixaController::class, 'store'])->name('arquivos.store');
    Route::delete('/arquivos/{id}', [ArquivoCaixaController::class, 'destroy'])->name('arquivos.destroy');
});

// ==========================================
// ROTAS DO DIÁRIO DE CAIXA
// ==========================================
Route::middleware(['auth'])->prefix('diario-caixa')->name('diario-caixa.')->group(function () {
    Route::get('/', [DiarioCaixaController::class, 'index'])->name('index');
    Route::post('/', [DiarioCaixaController::class, 'store'])->name('store');
    Route::delete('/{id}', [DiarioCaixaController::class, 'destroy'])->name('destroy');
    Route::post('/preview', [DiarioCaixaController::class, 'preview'])->name('preview');
    Route::match(['GET', 'POST'], '/exportar', [DiarioCaixaController::class, 'exportar'])->name('exportar');
    
    Route::post('/arquivos', [ArquivoCaixaController::class, 'store'])->name('arquivos.store');
    Route::delete('/arquivos/{id}', [ArquivoCaixaController::class, 'destroy'])->name('arquivos.destroy');
});

// ==========================================
// ROTAS DE FATURAS E PAGAMENTOS (FORA DO DIÁRIO)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::resource('faturas', FaturaController::class);
    Route::resource('pagamentos', PagamentoController::class);
    Route::get('pagamentos/confirmar/{id}', [PagamentoController::class, 'confirmar'])->name('pagamentos.confirmar');
});

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
    
    Route::get('/perfil', [AuthController::class, 'profile'])->name('profile.show');
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
        // Gestão de serviços/oportunidades
        Route::get('/index', [VendasController::class, 'index'])->name('index');
        Route::get('/create', [VendasController::class, 'create'])->name('create');
        Route::post('/', [VendasController::class, 'store'])->name('store');
        Route::get('/{id}', [VendasController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [VendasController::class, 'edit'])->name('edit');
        Route::put('/{id}', [VendasController::class, 'update'])->name('update');
        Route::delete('/{id}', [VendasController::class, 'destroy'])->name('destroy');
        
        // Pipeline
        Route::get('/pipeline', [VendasController::class, 'pipeline'])->name('pipeline');
        Route::patch('/{id}/status', [VendasController::class, 'updateStatus'])->name('updateStatus');
        
        // Automação
        Route::get('/{id}/proposta', [VendasController::class, 'gerarProposta'])->name('gerarProposta');
        Route::post('/{id}/converter', [VendasController::class, 'converterPedido'])->name('converterPedido');
        
        // Base de conhecimento (clientes)
        Route::get('/clientes', [VendasController::class, 'clientes'])->name('clientes');
        Route::get('/clientes/{id}', [VendasController::class, 'clientePerfil'])->name('cliente.perfil');
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
    // Fiscal
    Route::prefix('fiscal')->name('fiscal.')->group(function () {
        Route::get('/index', [FiscalController::class, 'index'])->name('index');
        Route::get('/relatorios', [FiscalController::class, 'relatorios'])->name('relatorios');
        Route::post('/exportar', [FiscalController::class, 'exportar'])->name('exportar');
        Route::get('/arquivo-digital', [FiscalController::class, 'arquivoIndex'])->name('arquivoIndex');
        Route::post('/upload', [FiscalController::class, 'upload'])->name('upload');
        Route::get('/download/{id}', [FiscalController::class, 'download'])->name('download');
        Route::delete('/documentos/{id}', [FiscalController::class, 'destroyDocumento'])->name('documentos.destroy');
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
        Route::get('/{cliente}', [ClienteController::class, 'show'])->name('show');
        Route::get('/edit/{cliente}', [ClienteController::class, 'edit'])->name('edit');
        Route::put('/{cliente}', [ClienteController::class, 'update'])->name('update');
        Route::delete('/{cliente}', [ClienteController::class, 'destroy'])->name('destroy');
    });
}); 