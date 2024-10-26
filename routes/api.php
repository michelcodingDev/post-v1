<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UserController;
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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::middleware('auth:sanctum')->group( function () {
    
    Route::resource('posts', PostsController::class);

    Route::post('post/create', [PostsController::class, 'create']);

    Route::get('posts/', [PostsController::class, 'index']);

    Route::post('post/{$id}', [PostsController::class, 'show']);
   
    Route::resource('users', UserController::class);
});

Route::post("users/login",[UserController::class,'login']);
Route::post('users/create', [UserController::class, 'create']);