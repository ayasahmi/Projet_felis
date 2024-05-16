<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'welcome';
});

//Route SuperAdmin
use App\Http\Controllers\SuperAdminController ;
Route::post('/super-admin/point-de-vente', [SuperAdminController::class, 'store'])->name('superadmin.storePointDeVente');
Route::get('/super-admin/souscriptions', [SuperAdminController::class, 'gestionSouscriptions'])->name('superadmin.gestionSouscriptions');
Route::put('/super-admin/utilisateurs/{utilisateurId}/modifier-type-souscription', [SuperAdminController::class, 'modifierTypeSouscription'])->name('superadmin.modifierTypeSouscription');


//Route Admin
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

Route::get('/api/planogrammes', [AdminController::class,'listerPlanogrammes']);
Route::post('/api/planogramme', [AdminController::class,'ajouterPlanogramme']);
Route::put('/api/planogramme/{id}', [AdminController::class,'modifierPlanogramme']);
Route::delete('/api/planogramme/{id}', [AdminController::class,'supprimerPlanogramme']);

Route::get('/api/criteres', [AdminController::class,'choixCriteres']);
Route::post('/api/criteres/{id_critere}', [AdminController::class,'enregistrerCriteres']);

Route::get('/api/points-de-vente', [AdminController::class,'listePointDeVente']);
Route::post('/api/points-de-vente/cocher', [AdminController::class,'cocherPointDeVente']);

Route::post('/api/visites/planifier', [AdminController::class,'planifierVisites']);


//Route Backoffice
use App\Http\Controllers\BackOfficeController;
Route::post('/planifier-visites', [BackOfficeController::class, 'planifierVisites']);
Route::put('/visites/{id}', [BackOfficeController::class, 'updateVisite']);


//Route Manager
use App\Http\Controllers\ManagerController;
Route::get('/point-de-vente/{pointeID}/images', [ManagerController::class, 'bibliothequeImages'])->name('api.bibliothequeImages');

//Route Merchendiser
use App\Http\Controllers\MerchandiserController;
Route::post('/verifier-localisation', [MerchandiserController::class,'verifierLocalisation']);
Route::get('/consulter-planning', [MerchandiserController::class,'consulterPlanning']);
Route::post('/enregistrer-resultats/{visiteId}', [MerchandiserController::class,'enregistrerResultats']);
Route::post('/marquer-presence/{visiteId}', [MerchandiserController::class,'marquerPresence']);
Route::post('/signaler-retard/{visiteId}', [MerchandiserController::class,'signalerRetard']);
Route::post('/terminer-visite/{visiteId}', [MerchandiserController::class,'terminerVisite']);
Route::post('/signaler-absence/{visiteId}', [MerchandiserController::class,'signalerAbsence']);
