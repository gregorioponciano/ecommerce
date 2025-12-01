<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\EnderecoController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produto/{id}', [HomeController::class, 'produto'])->name('produto');
Route::get('/buscar', [HomeController::class, 'buscar'])->name('buscar');

// Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas
Route::middleware(['auth'])->group(function () {
    // Carrinho
    Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
    Route::post('/carrinho/adicionar/{produtoId}', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
    Route::put('/carrinho/{id}', [CarrinhoController::class, 'atualizar'])->name('carrinho.atualizar');
    Route::delete('/carrinho/{id}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');

    // Pedidos
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/checkout', [PedidoController::class, 'checkout'])->name('pedidos.checkout');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');

    // Endereços
    Route::resource('enderecos', EnderecoController::class);
});