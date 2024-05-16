<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'bonj';
});
use App\Http\Controllers\AdminController ;
Route::get('/api/admin/utilisateurs/user', [AdminController::class, 'getUser']);
Route::get('/api/admin/utilisateurs', [AdminController::class, 'listeUtilisateurs']);
Route::post('/api/admin/utilisateurs', [AdminController::class, 'creerUsers']);
Route::get('/api/admin/utilisateurs/{id}/edit', [AdminController::class, 'editerUser']);
Route::put('/api/admin/utilisateurs/{id}', [AdminController::class, 'updateUser']);
Route::delete('/api/admin/utilisateurs/{id}', [AdminController::class, 'deleteUser']);

Route::get('/api/admin/produits', [AdminController::class, 'listeProduits']);
Route::post('/api/admin/produits', [AdminController::class, 'creerProduit']);
Route::get('/api/admin/produits/{id}/edit', [AdminController::class, 'editerProduit']);
Route::put('/api/admin/produits/{id}', [AdminController::class, 'updateProduit']);
Route::delete('/api/admin/produits/{id}', [AdminController::class, 'deleteProduit']);
