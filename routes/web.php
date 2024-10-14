<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as controller;

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

//Route::get('/',[controller::class,'public']);

//Categorias

Route::get('categorias', [controller::class, 'categoriasView'])->name('categoriasview');
Route::get('api/categorias', [controller::class, 'indexg']);

Route::put('/categorias/{id}', [controller::class, 'update']);
Route::post('/storeC', [controller::class, 'storeC']);
Route::delete('/categorias/{id}', [controller::class, 'destroy']);

//Libros


Route::get('libros', [controller::class, 'librosView'])->name('librosview');


// Route to fetch all books
Route::get('api/libros', [Controller::class, 'indexLibros']);

// Route to update a specific book by its ID
Route::put('/libros/{id}', [Controller::class, 'updateLibro']);

// Route to create a new book
Route::post('/storeLibro', [Controller::class, 'storeLibro']);

// Route to delete a specific book by its ID
Route::delete('/libros/{id}', [Controller::class, 'destroyLibro']);









Route::get('/', [controller::class, 'main']) ->name("/");


Route::get('/public',[controller::class,'public']);

Route::get('/prueba',[controller::class,'prueba']);
Route::get('search',[controller::class,'search'])->name('items');

Route::get('buscar',[controller::class,'buscar'])->name('buscar');


Route::get('look{object}',[controller::class,'buscarC'])->name('look');

Route::get('buscar_Autor{object}',[controller::class,'buscarA'])->name('buscar_Autor');

Route::get('buscar_Estado{object}',[controller::class,'buscarE'])->name('buscar_Estado');



//Admin

Auth::routes();

Route::middleware(['auth','is_user'])->group(function ()

{
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'user'])->name('home');

});

Route::middleware(['auth','is_admin'])->group(function (){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'admin'])->name('home');
});

Route::middleware(['auth','is_admin'])->group(function ()

{
    Route::get('home',[controller::class,'list']);

    Route::get('libros',[controller::class,'indexl'])->name('librosview');



    Route::get('excel',[controller::class,'excel']);


}
);




