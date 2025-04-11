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



Route::post('/login', [AuthController::class, 'login']);

Route::get('/', function () {
    return view('login.index');
});

Route::get('/login', [FrontRenderController::class, 'login'])
    ->name('login.index');

Route::post('/usuario/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('usuario.logout');

Route::get('/home', function () {
    return view('home');
})
    ->middleware('auth')
    ->name('index.home');
    



// Route::post('/login/v2', [UserController::class, 'loginV2'])->name('login.v2');
// Route::get('/login/v2', [FrontRenderController::class, 'loginV2']);

Route::get('usuario', [UserController::class, 'index'])
    ->middleware('auth')
    ->name('usuario.index');

Route::get('usuario/create', [UserController::class, 'create'])
    ->middleware('auth')
    ->name('usuario.create');



/*******************************************************************/

Route::get('competencia', [PeriodController::class, 'index'])
    ->middleware('auth')
    ->name('competencia.index');

Route::get('competencia/create', [PeriodController::class, 'create'])
    ->middleware('auth')
    ->name('competencia.create');

Route::post('competencia/store', [PeriodController::class, 'store'])
    ->middleware('auth')
    ->name('competencia.store');

/** A parte de UPDATE do CRUD*/
Route::get('competencia/{competenciaId}/edit', [PeriodController::class, 'edit'])
    ->middleware('auth')
    ->name('competencia.edit');

Route::put('competencia/{competenciaId}', [PeriodController::class, 'update'])
    ->middleware('auth')
    ->name('competencia.update');
/** -----------------------------*/


Route::delete('competencia/{competenciaId}', [PeriodController::class, 'destroy'])
    ->middleware('auth')
    ->name('competencia.destroy');

Route::get('/competencia/detalhes/{id}', [PeriodController::class, 'getDetalhesCompetenciaById'])
    ->middleware('auth');

/*******************************************************************/




Route::get('competencia/{competenciaId}/lancamento/create', [PeriodReleaseController::class, 'create'])
    ->middleware('auth')
    ->name('competencia.lancamento.create');

Route::post('competencia/{competenciaId}/lancamento', [PeriodReleaseController::class, 'store'])
    ->middleware('auth')
    ->name('competencia.lancamento.store');

Route::delete('lancamento/{lancamentoId}', [PeriodReleaseController::class, 'destroy'])
    ->middleware('auth')
    ->name('competencia.lancamento.destroy');

/** A parte de UPDATE de um lancamento da competencia*/
Route::get('lancamento/{lancamentoId}/edit', [PeriodReleaseController::class, 'edit'])
    ->middleware('auth')
    ->name('lancamento.edit');

Route::put('lancamento/{lancamentoId}', [PeriodReleaseController::class, 'update'])
    ->middleware('auth')
    ->name('lancamento.update');            
/** -----------------------------*/

/*******************************************************************/

Route::get('tipo-lancamento', [TypeReleaseController::class, 'getAll'])
    ->middleware('auth');


Route::get('tipo-lancamento', [TypeReleaseController::class, 'index'])
    ->middleware('auth')
    ->name('tipo-lancamento.index');

Route::get('tipo-lancamento/create', [TypeReleaseController::class, 'create'])
    ->middleware('auth')
    ->name('tipo-lancamento.create');