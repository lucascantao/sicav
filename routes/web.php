<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\VisitaController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Perfil de Usuario Logado
Route::middleware(['auth', 'registered'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Home
Route::get('/', function() {
    return redirect(route('pessoa.index'));
});

// Setores
Route::prefix('setor')->middleware(['auth', 'registered'])->group(function () {
    Route::middleware(['roles:Master,Auditor,Agente Portaria'])->group(function () {
        Route::get('/', [SetorController::class, 'index'])->name('setor.index');
        Route::get('/{setor}/show', [SetorController::class, 'show'])->name('setor.show');
        Route::post('/gerar-relatorio', [SetorController::class, 'gerarRelatorio'])->name('setor.gerarRelatorio');
    });
    Route::middleware(['roles:Master'])->group(function () {
        Route::get('/create', [SetorController::class, 'create'])->name('setor.create');
        Route::post('/', [SetorController::class, 'store'])->name('setor.store');
        Route::get('/{setor}/edit', [SetorController::class, 'edit'])->name('setor.edit');
        Route::put('/{setor}/update', [SetorController::class, 'update'])->name('setor.update');
        Route::get('/{id}/enable', [SetorController::class, 'enable'])->name('setor.enable');
        Route::get('/{id}/destroy', [SetorController::class, 'softDelete'])->name('setor.destroy');
    });
});

// Unidades
Route::prefix('unidade')->middleware(['auth', 'registered'])->group(function () {
    Route::middleware(['roles:Master,Auditor'])->group(function () {
        Route::get('/', [UnidadeController::class, 'index'])->name('unidade.index');
        Route::get('/{unidade}/show', [UnidadeController::class, 'show'])->name('unidade.show');
        Route::post('/gerar-relatorio', [UnidadeController::class, 'gerarRelatorio'])->name('unidade.gerarRelatorio');
    });
    Route::middleware(['roles:Master'])->group(function () {
        Route::get('/create', [UnidadeController::class, 'create'])->name('unidade.create');
        Route::post('/', [UnidadeController::class, 'store'])->name('unidade.store');
        Route::get('/{unidade}/edit', [UnidadeController::class, 'edit'])->name('unidade.edit');
        Route::put('/{unidade}/update', [UnidadeController::class, 'update'])->name('unidade.update');
        Route::get('/{id}/enable', [UnidadeController::class, 'enable'])->name('unidade.enable');
        Route::get('/{id}/destroy', [UnidadeController::class, 'softDelete'])->name('unidade.destroy');
    });
});

// Empresas
Route::prefix('empresa')->middleware(['auth', 'registered'])->group(function () {
    Route::middleware(['roles:Master,Auditor,Agente Portaria'])->group(function () {
        Route::get('/', [EmpresaController::class, 'index'])->name('empresa.index');
        Route::get('/{empresa}/show', [EmpresaController::class, 'show'])->name('empresa.show');
        Route::post('/gerar-relatorio', [EmpresaController::class, 'gerarRelatorio'])->name('empresa.gerarRelatorio');
    });

    Route::middleware(['roles:Master,Agente Portaria'])->group(function () {
        Route::get('/create', [EmpresaController::class, 'create'])->name('empresa.create');
        Route::post('/', [EmpresaController::class, 'store'])->name('empresa.store');
        Route::get('/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresa.edit');
        Route::put('/{empresa}/update', [EmpresaController::class, 'update'])->name('empresa.update');
    });

    Route::middleware(['roles:Master'])->group(function () {
        Route::get('/{id}/enable', [EmpresaController::class, 'enable'])->name('empresa.enable');
        Route::get('/{id}/destroy', [EmpresaController::class, 'softDelete'])->name('empresa.destroy');
    });

});

// Usuarios
Route::prefix('gerenciar-perfis')->middleware(['auth', 'registered', 'roles:Master'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/{user}/show', [UserController::class, 'show'])->name('user.show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->middleware('protected_access_user')->name('user.edit');
    Route::put('/{id}/update', [UserController::class, 'update'])->middleware('protected_access_user')->name('user.update');
    Route::get('/{id}/enable', [UserController::class, 'enable'])->middleware('protected_access_user')->name('user.enable');
    Route::get('/{id}/disable', [UserController::class, 'disable'])->middleware('protected_access_user')->name('user.disable');
    Route::post('/gerar-relatorio', [UserController::class, 'gerarRelatorio'])->name('user.gerarRelatorio');
    Route::get('/{id}/destroy', [UserController::class, 'softDelete'])->middleware(['roles:Master'])->name('user.destroy');
});

// Login
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Pessoas
Route::prefix('pessoa')->middleware(['auth', 'registered'])->group(function () {
    Route::middleware(['roles:Master,Auditor,Agente Portaria'])->group(function () {
        Route::get('/', [PessoaController::class, 'index'])->name('pessoa.index');
        Route::get('/{pessoa}/show', [PessoaController::class, 'show'])->name('pessoa.show');
        Route::get('/data', [PessoaController::class, 'getPessoasDataTable'])->name('pessoa.data');
        Route::get('/table', [PessoaController::class, 'getPessoasTable'])->name('pessoa.table');
    });

    Route::middleware(['roles:Master,Agente Portaria'])->group(function () {
        Route::get('/create', [PessoaController::class, 'create'])->name('pessoa.create');
        Route::post('/', [PessoaController::class, 'store'])->name('pessoa.store');
        Route::get('/{pessoa}/edit', [PessoaController::class, 'edit'])->name('pessoa.edit');
        Route::put('/{pessoa}/update', [PessoaController::class, 'update'])->name('pessoa.update');
        Route::get('/{id}/enable', [PessoaController::class, 'enable'])->name('pessoa.enable');
        Route::post('/salvar-imagem', [PessoaController::class, 'salvarImagem'])->name('salvar.imagem');
        Route::get('/gerar-relatorio', [PessoaController::class, 'gerarRelatorio'])->name('pessoa.gerarRelatorio');
    });
    Route::get('/{id}/destroy', [PessoaController::class, 'softDelete'])->middleware(['roles:Master'])->name('pessoa.destroy');
});

// Visitas
Route::prefix('visita')->middleware(['auth', 'registered'])->group(function () {
    Route::middleware(['roles:Master,Auditor,Agente Portaria'])->group(function () {
        Route::get('/{visita}/show', [VisitaController::class, 'show'])->name('visita.show');
        Route::get('/', [VisitaController::class, 'index'])->name('visita.index');
        Route::post('/gerar-relatorio', [VisitaController::class, 'gerarRelatorio'])->name('visita.gerarRelatorio');
        Route::get('/data', [VisitaController::class, 'getVisitasDataTable'])->name('visita.data');
        Route::get('/table', [VisitaController::class, 'getVisitasTable'])->name('visita.table');

        Route::middleware(['roles:Master,Agente Portaria'])->group(function () {
            Route::get('/create', [VisitaController::class, 'create'])->name('visita.create');
            Route::post('/', [VisitaController::class, 'store'])->name('visita.store');
            Route::get('/{visita}/edit', [VisitaController::class, 'edit'])->name('visita.edit');
            Route::put('/{visita}/update', [VisitaController::class, 'update'])->name('visita.update');
        });

        Route::middleware(['roles:Master'])->group(function () {
            Route::get('/{id}/enable', [VisitaController::class, 'enable'])->name('visita.enable');
            Route::get('/{id}/destroy', [VisitaController::class, 'softDelete'])->name('visita.destroy');
        });
    });
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    // Status de acesso
    Route::get('/status', function() {
                    return view('status.status');
                })->name('status');
});

