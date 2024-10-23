<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
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



Route::resource('posts', PostsController::class);

Route::post('post/create', [PostsController::class, 'create']);


Route::get('/login', function () {
    abort(response()->json(['message' => 'Token de autenticação inválido ou não fornecido.'], 401));
})->name('login');





