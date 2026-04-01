<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReceitaController;

use App\Http\Controllers\AuthController;

//login
Route::get('/', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

//receitas
Route::middleware('auth')->group(function () {
    Route::get('/receitas', [ReceitaController::class, 'index']);
    Route::get('/receitas/create', [ReceitaController::class, 'create']);
    Route::post('/receitas', [ReceitaController::class, 'store']);
    Route::get('/receitas/{id}/edit', [ReceitaController::class, 'edit']);
    Route::put('/receitas/{id}', [ReceitaController::class, 'update']);
    Route::delete('/receitas/{id}', [ReceitaController::class, 'destroy']);
});