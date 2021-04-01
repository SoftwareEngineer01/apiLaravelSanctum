<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PostController as PostV1;
use App\Http\Controllers\Api\V2\PostController as PostV2;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Usar todos los metodos
// Route::apiResource('v1/posts', App\Http\Controllers\Api\V1\PostController::class);

//Utilizamos solo para visualizar un metodo
//Route::apiResource('v1/posts', App\Http\Controllers\Api\V1\PostController::class)->only('show');

//Login
Route::Post('login', [
    App\Http\Controllers\Api\LoginController::class,
    'login'
]);

//Version #1

//Visualizar varios metodos
// Route::apiResource('v1/posts', PostV1::class)
//     ->only(['index', 'show', 'destroy'])
//     ->middleware('auth:sanctum');


// //Version #2
// Route::apiResource('v2/posts', PostV2::class)
//     ->only(['index', 'show', 'destroy'])
//     ->middleware('auth:sanctum');


//Protegiendo las rutas
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('v1/posts', PostV1::class);
    Route::apiResource('v2/posts', PostV2::class);
});
