<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServidorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/update-ldap-users', [ServidorController::class, 'updateServidores'])->name('servidor.update-ldap-users');
Route::post('/servidores-by-setor', [ServidorController::class, 'getServidores'])->name('visita.servidores');
Route::get('/setores-by-servidor', [ServidorController::class, 'getSetorByServidores'])->name('visita.setores');


