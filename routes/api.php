<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LojaController;
use App\Http\Controllers\ProdutoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function(){
    return "pong";
});

Route::prefix('loja')->group(function(){
    Route::get('/', [LojaController::class, 'index']);
    Route::get('/{id}', [LojaController::class, 'show']);
    Route::post('/', [LojaController::class, 'store']);
    Route::match(['put', 'patch'], '/{id}', [LojaController::class, 'update']);
    Route::delete('/{id}', [LojaController::class, 'destroy']);
});

Route::prefix('produto')->group(function(){
    Route::get('/', [ProdutoController::class, 'index']);
    Route::get('/{id}', [ProdutoController::class, 'show']);
    Route::post('/', [ProdutoController::class, 'store']);
    Route::match(['put', 'patch'], '/{id}', [ProdutoController::class, 'update']);
    Route::delete('/{id}', [ProdutoController::class, 'delete']);
});