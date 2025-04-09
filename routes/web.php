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



//Route::post('/usuario', [UserController::class, 'store']);
//Route::get('/usuario', [UserController::class, 'index']);
//Route::put('/usuario/{id}', [UserController::class, 'update']);
//Route::delete('/usuario/{id}', [UserController::class, 'destroy']);

// Route::resource('usuario', UserController::class)
//     ->middleware('auth');

Route::get('usuario', [UserController::class, 'index'])
    ->middleware('auth')
    ->name('usuario.index');

Route::get('usuario/create', [UserController::class, 'create'])
    ->middleware('auth')
    ->name('usuario.create');

// Route::post('usuario', [UserController::class, 'store'])->middleware('auth')->name('usuario.store');
// Route::get('usuario/{usuario}', [UserController::class, 'show'])->middleware('auth')->name('usuario.show');
// Route::get('usuario/{usuario}/edit', [UserController::class, 'edit'])->middleware('auth')->name('usuario.edit');
// Route::put('usuario/{usuario}', [UserController::class, 'update'])->middleware('auth')->name('usuario.update');
// Route::delete('usuario/{usuario}', [UserController::class, 'destroy'])->middleware('auth')->name('usuario.destroy');

Route::post('/usuario/logout', [AuthController::class, 'logout'])
    ->name('usuario.logout')
    ->middleware('auth');



//Route::resource('competencia', PeriodController::class)
//    ->middleware('auth')->except(['index', 'create', 'store']);

Route::get('/carteira/competencia', function () {
    echo 'olá, estou na rota /carteira/competencia';
}); //esse aqui podemos excluir?????


Route::get('competencia', [PeriodController::class, 'index'])
    ->name('competencia.index')
    ->middleware('auth');

Route::get('competencia/create', [PeriodController::class, 'create'])
    ->name('competencia.create')
    ->middleware('auth');

Route::post('competencia/store', [PeriodController::class, 'store'])
    ->name('competencia.store')
    ->middleware('auth');

Route::get('competencia/{competenciaId}/edit', [PeriodController::class, 'edit'])
    ->name('competencia.edit')
    ->middleware('auth');

Route::put('competencia/{competenciaId}', [PeriodController::class, 'update'])
    ->name('competencia.update')
    ->middleware('auth');


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

Route::delete('lancamento/edit', [PeriodReleaseController::class, 'edit'])
    ->name('competencia.lancamento.edit')
    ->middleware('auth');

Route::delete('lancamento/{lancamentoId}', [PeriodReleaseController::class, 'destroy'])
    ->name('competencia.lancamento.destroy')
    ->middleware('auth');

//todo: verificar o modelo de url a ser utilizado.
//Route::post('/competencia/{competenciaId}/lancamento', [UserController::class, 'store']);


Route::get('tipo-lancamento', [TypeReleaseController::class, 'getAll'])
    ->middleware('auth');


//Route::resource('tipo-lancamento', TypeReleaseController::class)
//    ->middleware('auth');




