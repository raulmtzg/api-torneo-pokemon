<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompetidoresController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\PokemonController;

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


Route::post('competidores', [CompetidoresController::class, 'store']);

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function (){
    
    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::get('competidores', [CompetidoresController::class, 'index']);

    //Estadisticas

    //Totalentrenadores
    Route::get('entrenadores', [EstadisticasController::class, 'entrenadores']);
    //Pokemon mas utilizado
    Route::get('pokemonpopular', [EstadisticasController::class, 'pokemonPopular']);
    // Top 5 Pokemons
    Route::get('pokemontop', [EstadisticasController::class, 'pokemonsTop']);
    // Top 5 Pokemons mas fuertes
    Route::get('pokemonhp', [EstadisticasController::class, 'pokemonsHp']);
    // Total por tipo seleccionados
    Route::get('pokemontipos', [EstadisticasController::class, 'pokemonsTipos']);
    
    
});
