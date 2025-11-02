<?php

use App\Http\Controllers\AssuntoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('autores', AutorController::class)->parameters([
    'autores' => 'autor'
]);
Route::resource('assuntos', AssuntoController::class);
Route::resource('livros', LivroController::class);

Route::prefix('relatorio')->group(function () {
    Route::get('/livros', [RelatorioController::class, 'livrosPorAutor'])->name('relatorio.livros');
    Route::get('/livros/excel', [RelatorioController::class, 'exportarExcel'])->name('relatorio.excel');
    Route::get('/livros/pdf', [RelatorioController::class, 'exportarPDF'])->name('relatorio.pdf');
});
