<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    FuncionarioController,
    DepartamentoController,
    CargoController,
    HomeController,
    LoginController,
    RegisterController,
    TarefasController
};

Route::get('/login', [LoginController::class, 'loginView'])->name('login.view');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', [RegisterController::class, 'registerView'])->name('register.view');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    

    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    
    Route::get('/funcionarios', [FuncionarioController::class, 'index'])->name('funcionarios.index');
    Route::get('/funcionarios/create', [FuncionarioController::class, 'create'])->name('funcionarios.create');
    Route::post('/funcionarios', [FuncionarioController::class, 'store'])->name('funcionarios.store');
    Route::get('/funcionarios/{id}', [FuncionarioController::class, 'edit'])->name('funcionarios.edit');
    Route::put('/funcionarios/{id}', [FuncionarioController::class, 'update'])->name('funcionarios.update');
    Route::delete('/funcionarios/{id}', [FuncionarioController::class, 'destroy'])->name('funcionarios.destroy');
    
    Route::get('/departamentos', [DepartamentoController::class, 'index'])->name('departamentos.index');
    Route::get('/departamentos/create', [DepartamentoController::class, 'create'])->name('departamentos.create');
    Route::post('/departamentos', [DepartamentoController::class, 'store'])->name('departamentos.store');
    Route::get('/departamentos/{id}', [DepartamentoController::class, 'edit'])->name('departamentos.edit');
    Route::put('/departamentos/{id}', [DepartamentoController::class, 'update'])->name('departamentos.update');
    Route::delete('/departamentos/{id}', [DepartamentoController::class, 'destroy'])->name('departamentos.destroy');
    
    Route::get('/cargos', [CargoController::class, 'index'])->name('cargos.index');
    Route::get('/cargos/create', [CargoController::class, 'create'])->name('cargos.create');
    Route::post('/cargos', [CargoController::class, 'store'])->name('cargos.store');
    Route::get('/cargos/{id}', [CargoController::class, 'edit'])->name('cargos.edit');
    Route::put('/cargos/{id}', [CargoController::class, 'update'])->name('cargos.update');
    Route::delete('/cargos/{id}', [CargoController::class, 'destroy'])->name('cargos.destroy');

    Route::get('/tarefas', [TarefasController::class, 'index'])->name('tarefas.index');
    Route::get('/tarefas/create', [TarefasController::class, 'create'])->name('tarefas.create');
    Route::post('/tarefas', [TarefasController::class, 'store'])->name('tarefas.store');
    Route::get('/tarefas/{id}', [TarefasController::class, 'edit'])->name('tarefas.edit');
    Route::put('/tarefas/{id}', [TarefasController::class, 'update'])->name('tarefas.update');
    Route::delete('/tarefas/{id}', [TarefasController::class, 'destroy'])->name('tarefas.destroy');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

