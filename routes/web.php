<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [UserController::class, 'index']);

Route::get('/plano/{plano}', [UserController::class, 'plano_escolhido']);

Route::get('/tratar_dados', [UserController::class, 'tratar_dados']);

Route::get('/orcamento', [UserController::class, 'orcamento']);