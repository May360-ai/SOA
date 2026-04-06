<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AutorController;
use App\Http\Controllers\LibroController;

Route::get('/', [AutorController::class, 'index']);

// CRUD de Autores con parámetro 'dni'
Route::resource('autores', AutorController::class)->parameters([
    'autores' => 'dni'
]);

// CRUD de Libros con parámetro 'codigo'
Route::resource('libros', LibroController::class)->parameters([
    'libros' => 'codigo'
]);
