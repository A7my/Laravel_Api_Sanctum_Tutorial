<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;

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

Route::get('/register' , [UserController::class , 'register']);
Route::get('/login'    , [UserController::class , 'login']);
Route::post('/image'    , [UserController::class , 'image']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('profile' , [UserController::class , 'profile']);
    Route::get('logout' , [UserController::class , 'logout']);
    Route::get('create' , [ProjectController::class , 'create']);
    Route::get('projects' , [ProjectController::class , 'projects']);
    Route::get('single/{id}' , [ProjectController::class , 'single']);
    Route::get('delete/{id}' , [ProjectController::class , 'delete']);
    Route::get('search/{name}' , [ProjectController::class , 'search']);
});
