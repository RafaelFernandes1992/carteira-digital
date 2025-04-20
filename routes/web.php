<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontRenderController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PeriodReleaseController;
use App\Http\Controllers\TypeReleaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CreditCardController;
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

// Rota para login (POST) - Tentando autenticar o usuário
Route::post('/login', [AuthController::class, 'login']);

// Rota para logout (POST) - Desautenticar o usuário
Route::post('/usuario/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('usuario.logout');

// Rota para o formulário de login (GET)
Route::get('/login', [FrontRenderController::class, 'login'])->name('login.index');

// Rota para a home (inicial) - Você pode querer uma rota protegida com middleware auth
Route::get('/', function () {
    return view('home');  // Ou a página inicial desejada
})->middleware('auth'); // Ou você pode adicionar um middleware aqui para proteger essa rota




// Rota para exibir o formulário "Esqueceu a Senha"
Route::get('/esqueceu-senha', [AuthController::class, 'showForgotPasswordForm'])
    ->name('senha.request');

// Rota para enviar o link de redefinição de senha
Route::post('/esqueceu-senha', [AuthController::class, 'sendResetLink'])
    ->name('senha.email');




Route::get('/esqueci-senha', function () {
    return 'Página de recuperação de senha ainda não implementada.';
})->name('password.request');


Route::get('/esqueci-senha/{token}', [PasswordController::class, 'showResetForm'])
    ->name('password.reset');



Route::get('/cadastro', [UserController::class, 'create'])
    ->name('users.create'); 
Route::post('/cadastro', [UserController::class, 'store'])
    ->name('users.store');  


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

Route::get('tipo-lancamento-getAll', [TypeReleaseController::class, 'getAll'])
    ->middleware('auth');

Route::get('tipo-lancamento', [TypeReleaseController::class, 'index'])
    ->middleware('auth')
    ->name('tipo-lancamento.index');

Route::get('tipo-lancamento/create', [TypeReleaseController::class, 'create'])
    ->middleware('auth')
    ->name('tipo-lancamento.create');

Route::post('tipo-lancamento/store', [TypeReleaseController::class, 'store'])
    ->middleware('auth')
    ->name('tipo-lancamento.store');

Route::delete('tipo-lancamento/{typeReleaseId}', [TypeReleaseController::class, 'destroy'])
    ->middleware('auth')
    ->name('tipo-lancamento.destroy');


/*******************************************************************/



Route::get('carro', [CarController::class, 'index'])
    ->middleware('auth')
    ->name('carro.index');

Route::get('carro/create', [CarController::class, 'create'])
    ->middleware('auth')
    ->name('carro.create');

Route::post('carro/store', [CarController::class, 'store'])
    ->middleware('auth')
    ->name('carro.store');

Route::delete('carro/{typeReleaseId}', [CarController::class, 'destroy'])
    ->middleware('auth')
    ->name('carro.destroy');