<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommentaireController;
use App\Http\Middleware\EnsureUserIsAdmin;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Toutes les routes du contrôleur " CommentaireController" sont maintenant prisonnières du
    // "middleware" relatif à l’authentification. Ce faisant, un utilisateur doit préalablement
    // s’authentifier pour accéder à une des routes du contrôleur " CommentaireController".
    Route::controller(CommentaireController::class)->group(function() {
    Route::get('/commentaires', 'index')->name('commentaires');
    Route::get('/redaction/commentaire', 'create')->name('redactionCommentaire');
    Route::post('/insertion/commentaire', 'store')->name('insertionCommentaire');
    });
   });



Route::controller(ProduitController::class)->group(function() {
    Route::get('/produits', 'index')->name('produits');
    Route::get('/produit/{id}', 'show')->name('produit');
    Route::get('/produits/categorie/{id}', 'show')->name('produitsCategorie');
    Route::get('/modification/produit', 'edit')->name('modificationProduit')->middleware(EnsureUserIsAdmin::class);
    Route::post('/suppression/produit', 'destroy')->name('suppressionProduit')->middleware(EnsureUserIsAdmin::class);
    Route::post('/enregistrement/produit', 'update')->name('enregistrementProduit')->middleware(EnsureUserIsAdmin::class);
   });

Route::controller(CategorieController::class)->group(function() {
    Route::get('/categories', 'index')->name('categories');
    Route::get('/categorie/{id}', 'show')->name('categorie');
   });



require __DIR__.'/auth.php';
