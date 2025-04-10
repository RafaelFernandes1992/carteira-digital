<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontRenderController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PeriodReleaseController;
use App\Http\Controllers\TypeReleaseController;
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
    return view('login');
});

Route::get('/home', function () {
    return view('home');
})->name('index.home')->middleware('auth');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/login', [FrontRenderController::class, 'login'])->name('index.login');

// Route::post('/login/v2', [UserController::class, 'loginV2'])->name('login.v2');
// Route::get('/login/v2', [FrontRenderController::class, 'loginV2']);

Route::get('usuario', [UserController::class, 'index'])
    ->middleware('auth')
    ->name('usuario.index');

Route::get('usuario/create', [UserController::class, 'create'])
    ->middleware('auth')
    ->name('usuario.create');

Route::post('/usuario/logout', [AuthController::class, 'logout'])
    ->name('usuario.logout')
    ->middleware('auth');


Route::get('competencia', [PeriodController::class, 'index'])
    ->name('competencia.index')
    ->middleware('auth');

Route::get('competencia/create', [PeriodController::class, 'create'])
    ->name('competencia.create')
    ->middleware('auth');

Route::post('competencia/store', [PeriodController::class, 'store'])
    ->name('competencia.store')
    ->middleware('auth');

/** A parte de UPDATE de um CRUD*/
Route::get('competencia/{competenciaId}/edit', [PeriodController::class, 'edit'])
    ->name('competencia.edit')
    ->middleware('auth');

Route::put('competencia/{competenciaId}', [PeriodController::class, 'update'])
    ->name('competencia.update')
    ->middleware('auth');
/** -----------------------------*/


Route::delete('competencia/{competenciaId}', [PeriodController::class, 'destroy'])
    ->name('competencia.destroy')
    ->middleware('auth');

Route::get('/competencia/detalhes/{id}', [PeriodController::class, 'getDetalhesCompetenciaById'])
    ->middleware('auth');

Route::get('competencia/{competenciaId}/lancamento/create', [PeriodReleaseController::class, 'create'])
    ->name('competencia.lancamento.create')
    ->middleware('auth');

Route::post('competencia/{competenciaId}/lancamento', [PeriodReleaseController::class, 'store'])
    ->name('competencia.lancamento.store')
    ->middleware('auth');

Route::delete('lancamento/{lancamentoId}', [PeriodReleaseController::class, 'destroy'])
    ->name('competencia.lancamento.destroy')
    ->middleware('auth');

/** A parte de UPDATE de um lancamento da competencia*/
Route::get('lancamento/{lancamentoId}/edit', [PeriodReleaseController::class, 'edit'])
    ->name('lancamento.edit')
    ->middleware('auth');

Route::put('lancamento/{lancamentoId}', [PeriodReleaseController::class, 'update'])
    ->name('lancamento.update')
    ->middleware('auth');
/** -----------------------------*/


Route::get('tipo-lancamento', [TypeReleaseController::class, 'getAll'])
    ->middleware('auth');
