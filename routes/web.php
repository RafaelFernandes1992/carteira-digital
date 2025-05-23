<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreditCardReleaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontRenderController;
use App\Http\Controllers\PeriodController;
use App\Services\PeriodService;
use App\Http\Controllers\PeriodReleaseController;
use App\Http\Controllers\TypeReleaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\CarReleaseController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\WalletReportController;
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

// Rota para a home (inicial)
Route::get('/', function () {
    return view('home');
})->middleware('auth');

Route::get('/inicio', function () {
    return view('home');
})->middleware('auth')
    ->name('inicio');


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


Route::get('usuario', [UserController::class, 'index'])
    ->middleware('auth')
    ->name('usuario.index');

Route::get('usuario/create', [UserController::class, 'create'])
    ->middleware('auth')
    ->name('usuario.create');

Route::delete('usuario/{userId}', [UserController::class, 'destroy'])
    ->middleware('auth')
    ->name('usuario.destroy');


/*******************************************************************/

Route::get('competencia-carteira', [PeriodController::class, 'index'])
    ->middleware('auth')
    ->name('competencia-carteira.index');

Route::get('competencia-carteira/create', [PeriodController::class, 'create'])
    ->middleware('auth')
    ->name('competencia-carteira.create');

Route::post('competencia-carteira/store', [PeriodController::class, 'store'])
    ->middleware('auth')
    ->name('competencia-carteira.store');

Route::get('competencia-carteira/{competenciaId}/edit', [PeriodController::class, 'edit'])
    ->middleware('auth')
    ->name('competencia-carteira.edit');

Route::put('competencia-carteira/{competenciaId}', [PeriodController::class, 'update'])
    ->middleware('auth')
    ->name('competencia-carteira.update');

Route::delete('competencia-carteira/{competenciaId}', [PeriodController::class, 'destroy'])
    ->middleware('auth')
    ->name('competencia-carteira.destroy');

//Extra -- esse aqui serve para retornar os totalizadores da soma de receita, despesa, investimento da tela
//retorna um array
//Lançamentos da Competência da Carteira

Route::get('/competencia-carteira/detalhes/{id}', [PeriodService::class, 'getDetalhesCompetenciaById'])
    ->middleware('auth');

Route::post('/competencia-carteira/{competenciaId}/rotineiros', [PeriodController::class, 'addRoutineItems'])
    ->middleware('auth')
    ->name('competencia-carteira.rotineiros');



/*******************************************************************/

Route::get('competencia/{competenciaId}/lancamento/create', [PeriodReleaseController::class, 'create'])
    ->middleware('auth')
    ->name('competencia.lancamento.create');

Route::post('competencia/{competenciaId}/lancamento', [PeriodReleaseController::class, 'store'])
    ->middleware('auth')
    ->name('competencia.lancamento.store');

Route::get('competencia/lancamento/{lancamentoId}/edit', [PeriodReleaseController::class, 'edit'])
    ->middleware('auth')
    ->name('competencia.lancamento.edit');

Route::put('competencia/lancamento/{lancamentoId}', [PeriodReleaseController::class, 'update'])
    ->middleware('auth')
    ->name('competencia.lancamento.update');

Route::delete('competencia/lancamento/{lancamentoId}', [PeriodReleaseController::class, 'destroy'])
    ->middleware('auth')
    ->name('competencia.lancamento.destroy');

/*******************************************************************/

/** Inicio READ do CRUD */
Route::get('tipo-lancamento', [TypeReleaseController::class, 'index'])
    ->middleware('auth')
    ->name('tipo-lancamento.index');
/** Fim READ do CRUD */

/** Inicio CREATE do CRUD */
Route::get('tipo-lancamento/create', [TypeReleaseController::class, 'create'])
    ->middleware('auth')
    ->name('tipo-lancamento.create');
Route::post('tipo-lancamento/store', [TypeReleaseController::class, 'store'])
    ->middleware('auth')
    ->name('tipo-lancamento.store');
/** Fim CREATE do CRUD */

/** Inicio UPDATE do CRUD */
Route::get('tipo-lancamento/{typeReleaseId}/edit', [TypeReleaseController::class, 'edit'])
    ->middleware('auth')
    ->name('tipo-lancamento.edit');
Route::put('tipo-lancamento/{typeReleaseId}', [TypeReleaseController::class, 'update'])
    ->middleware('auth')
    ->name('tipo-lancamento.update');
/** Fim UPDATE do CRUD */

/** Inicio DELETE do CRUD */
Route::delete('tipo-lancamento/{typeReleaseId}', [TypeReleaseController::class, 'destroy'])
    ->middleware('auth')
    ->name('tipo-lancamento.destroy');
/** Fim DELETE do CRUD */

/** Extras: End-point-que-usa-Json-no-retorno */
Route::get('tipo-lancamento/{typeReleaseId}', [TypeReleaseController::class, 'show'])
    ->middleware('auth');

Route::get('tipo-lancamento-getAll', [TypeReleaseController::class, 'getAll'])
    ->middleware('auth');

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

Route::get('carro/{carId}/edit', [CarController::class, 'edit'])
   ->middleware('auth')
   ->name('carro.edit');

Route::put('carro/{carId}', [CarController::class, 'update'])
   ->middleware('auth')
   ->name('carro.update');

Route::delete('carro/{carId}', [CarController::class, 'destroy'])
    ->middleware('auth')
    ->name('carro.destroy');

/*******************************************************************/

Route::get('cartao-credito', [CreditCardController::class, 'index'])
    ->middleware('auth')
    ->name('cartao-credito.index');

Route::get('cartao-credito/create', [CreditCardController::class, 'create'])
    ->middleware('auth')
    ->name('cartao-credito.create');

Route::post('cartao-credito/store', [CreditCardController::class, 'store'])
    ->middleware('auth')
    ->name('cartao-credito.store');

Route::get('cartao-credito/{creditCardId}/edit', [CreditCardController::class, 'edit'])
    ->middleware('auth')
    ->name('cartao-credito.edit');

Route::put('cartao-credito/{creditCardId}', [CreditCardController::class, 'update'])
    ->middleware('auth')
    ->name('cartao-credito.update');

Route::delete('cartao-credito/{creditCardId}', [CreditCardController::class, 'destroy'])
    ->middleware('auth')
    ->name('cartao-credito.destroy');



/*****************LANCAMENTOS DO CARTÃO**************************************************/

Route::get('competencia/{competenciaId}/cartao-credito/lancamento/create',[CreditCardReleaseController::class, 'create'])
    ->middleware('auth')
    ->name('competencia.cartao-credito.lancamento.create');

Route::post('competencia/{competenciaId}/cartao-credito/lancamento',[CreditCardReleaseController::class, 'store'])
    ->middleware('auth')
    ->name('competencia.cartao-credito.lancamento.store');

Route::get('cartao-credito/lancamento/{creditCardReleaseId}/edit', [CreditCardReleaseController::class, 'edit'])
   ->middleware('auth')
   ->name('cartao-credito.lancamento.edit');

Route::put('cartao-credito/lancamento/{creditCardReleaseId}', [CreditCardReleaseController::class, 'update'])
   ->middleware('auth')
   ->name('cartao-credito.lancamento.update');

Route::delete('cartao-credito/lancamento/{creditCardReleaseId}', [CreditCardReleaseController::class, 'destroy'])
   ->middleware('auth')
   ->name('cartao-credito.lancamento.destroy');


Route::get('competencia/{competenciaId}/cartao-credito/{creditCardId}/pagamento-fatura/', [CreditCardReleaseController::class, 'fatura'])
    ->name('cartao-credito.pagamento-fatura');

Route::post('cartao-credito/pagar-fatura', [CreditCardReleaseController::class, 'pagarFatura'])
    ->name('cartao-credito.pagar-fatura');

/*******************************************************************/


/*******************************************************************/

Route::get('competencia/{competenciaId}/carro/lancamento/create',[CarReleaseController::class, 'create'])
    ->middleware('auth')
    ->name('competencia.carro.lancamento.create');

Route::post('competencia/{competenciaId}/carro/lancamento',[CarReleaseController::class, 'store'])
    ->middleware('auth')
    ->name('competencia.carro.lancamento.store');

Route::get('carro/lancamento/{carReleaseId}/edit', [CarReleaseController::class, 'edit'])
   ->middleware('auth')
   ->name('carro.lancamento.edit');

Route::put('carro/lancamento/{carReleaseId}', [CarReleaseController::class, 'update'])
   ->middleware('auth')
   ->name('carro.lancamento.update');

Route::delete('carro/lancamento/{carReleaseId}', [CarReleaseController::class, 'destroy'])
   ->middleware('auth')
   ->name('carro.lancamento.destroy');

/*******************************************************************/



Route::get('/dashboard/competencia', [DashboardController::class, 'totalizarPorCompetenciaAnual']);
Route::get('/dashboard/cards', [DashboardController::class, 'quantitativosCards']);


// Route::get('alerta-notificacao', function () {
//     return view('alert-notification.index');
// })->middleware('auth')->name('alerta-notificacao.index');


Route::get('alerta-notificacao', [AlertController::class, 'alertasDespesas'])
    ->name('alerta-notificacao.index');
Route::put('alerta-notificacao/{id}/pagar', [AlertController::class, 'marcarComoPago'])
    ->name('alerta-notificacao.marcarComoPago');

Route::get('/relatorio-carteira', [WalletReportController::class, 'index'])
    ->name('relatorio-carteira.index');
Route::get('relatorio-carteira/pdf', [WalletReportController::class, 'downloadPdf'])
->name('relatorio-carteira.pdf');
