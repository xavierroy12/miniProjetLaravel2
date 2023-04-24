<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Middleware\EnsureUserIsAdmin;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ProduitController::class)->group(function() {
    Route::get('/produit/{id}', 'show')->name('produitApi')->middleware('auth:sanctum');
    Route::post('/insertion/produit', 'store')->name('insertionProduitApi')->middleware(['auth:sanctum', EnsureUserIsAdmin::class]);


   });
Route::controller(CategorieController::class)->group(function() {
    Route::get('/categorie', 'index')->name('categorieApi');
    Route::post('/insertion/categorie', 'store')->name('insertionCategorieApi')->middleware(['auth:sanctum', EnsureUserIsAdmin::class]);
   });

Route::post('/token', [RegisteredUserController::class, 'show'])->name('token');



