<?php

use App\Http\Controllers\AssuntoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivroController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('autores', AutorController::class)->parameters([
    'autores' => 'autor'
]);
Route::resource('assuntos', AssuntoController::class);
Route::resource('livros', LivroController::class);

//Route::get('/relatorio/livros', [RelatorioController::class, 'livrosPorAutor'])->name('relatorio.livros');
