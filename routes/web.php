<?php

use App\Http\Controllers\FrontRenderController;
use App\Http\Controllers\PostingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('home');
})->middleware('auth');

Route::get('/home', function () {
    return view('home');
})->name('index.home')->middleware('auth');


Route::get('/carteira/competencia', function () {
    echo 'olá, estou na rota /carteira/competencia';
});

//Route::post('/usuario', [UserController::class, 'store']);
//Route::get('/usuario', [UserController::class, 'index']);
//Route::put('/usuario/{id}', [UserController::class, 'update']);
//Route::delete('/usuario/{id}', [UserController::class, 'destroy']);

Route::post('/login/v2', [UserController::class, 'loginV2'])->name('login.v2');
Route::get('/login/v2', [FrontRenderController::class, 'loginV2']);


Route::post('/login', [UserController::class, 'login']);
Route::get('/login', [FrontRenderController::class, 'login'])->name('index.login');

Route::post('/usuario/logout', [UserController::class, 'logout'])
    ->name('usuario.logout')
    ->middleware('auth');

Route::resource('usuario', UserController::class)
    ->middleware('auth');

Route::resource('tipo-lancamento', PostingController::class)
    ->middleware('auth');




