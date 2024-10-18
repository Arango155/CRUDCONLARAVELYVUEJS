<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\NasaApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main route
Route::get('/', [controller::class, 'main']) ->name("/");

// Categorías routes
Route::get('categorias', [Controller::class, 'categoriasView'])->name('categoriasview');
Route::get('api/categorias', [Controller::class, 'indexg']);
Route::put('/categorias/{id}', [Controller::class, 'update']);
Route::post('/storeC', [Controller::class, 'storeC']);
Route::delete('/categorias/{id}', [Controller::class, 'destroy']);

// NASA Data route
Route::get('/nasa-data', [NasaApiController::class, 'getNasaData']);

// Libros routes
Route::get('libros', [Controller::class, 'librosView'])->name('librosview');
Route::get('api/libros', [Controller::class, 'indexLibros']);
Route::put('/libros/{id}', [Controller::class, 'updateLibro']);
Route::post('/storeLibro', [Controller::class, 'storeLibro']);
Route::delete('/libros/{id}', [Controller::class, 'destroyLibro']);

// Additional routes
Route::get('/public', [Controller::class, 'public']);
Route::get('/prueba', [Controller::class, 'prueba']);
Route::get('search', [Controller::class, 'search'])->name('items');
Route::get('buscar', [Controller::class, 'buscar'])->name('buscar');
Route::get('look/{object}', [Controller::class, 'buscarC'])->name('look');
Route::get('buscar_Autor/{object}', [Controller::class, 'buscarA'])->name('buscar_Autor');
Route::get('buscar_Estado/{object}', [Controller::class, 'buscarE'])->name('buscar_Estado');

// Admin routes
Auth::routes();

Route::middleware(['auth', 'is_user'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'user'])->name('home');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'admin'])->name('home');
    Route::get('home', [Controller::class, 'list']);
    Route::get('libros', [Controller::class, 'indexl'])->name('librosview');
    Route::get('excel', [Controller::class, 'excel']);
});
