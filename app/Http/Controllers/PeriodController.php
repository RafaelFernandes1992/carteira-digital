<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Http\Requests\StorePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;
use App\Models\PeriodRelease;
use App\Traits\ValidateScopeTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PeriodController extends Controller
{
    use ValidateScopeTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $periods = Period::where('user_id', $user->id)->get();
        $periods = $periods->map(function ($period) {
            $competencia = Carbon::createFromDate($period->ano, $period->mes, 1);
            return [
                'id' => $period->id,
                'competencia' => $competencia->format('m/Y'),
                'descricao' => $period->descricao,
                'saldo_inicial' => $period->saldo_inicial,
                'saldo_atual' => $period->saldo_atual,
                'created_at' => Carbon::parse($period->updated_at)->format('d/m/Y H:i:s'),
            ];
        });
        return view('components.competencia.index')->with(['items' => $periods]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anoAtual = Carbon::now()->format('Y');
        $mesAtual = Carbon::now()->format('m');
        return view('components.competencia.create')
            ->with([
                'anoAtual' => $anoAtual,
                'mesAtual' => $mesAtual
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePeriodRequest $request): JsonResponse
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = auth()->user()->id;
            $dados['saldo_atual'] = $dados['saldo_inicial'];
            $model = Period::create($dados);

            return response()->json([
                'message' => 'Competência criada com sucesso!',
                'data' => $model
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getDetalhesCompetenciaById(string $id): array
    {
//        try {
        $period = Period::find($id);
        $userId = $period->user_id;
        $this->validateScope($userId);

        $somaDebitadas = PeriodRelease::where('period_id', $id)
            ->where('situacao', 'debitado')
            ->sum('valor_total');

        $somaCreditadas = PeriodRelease::where('period_id', $id)
            ->where('situacao', 'creditado')
            ->sum('valor_total');

        $somaNaoDebitadas = PeriodRelease::where('period_id', $id)
            ->where('situacao', 'nao_debitado')
            ->sum('valor_total');


        //debitada + não debitada = previsão debitada
        //saldo atual = saldo atual - não debitada

        return [
            'debitadas_total' => (float)$somaDebitadas,
            'creditadas_total' => (float)$somaCreditadas,
            'nao_debitadas_total' => (float)$somaNaoDebitadas,
            'saldo_atual_previsto' => (float)$period->saldo_atual - $somaNaoDebitadas,
            'previsao_debitada' => (float)$somaDebitadas + $somaNaoDebitadas,
        ];


//            return response()->json([
//                'message' => 'Detalhes encontrados',
//                'data' => $dados
//            ], 201);
//
//        } catch (UnauthorizedScopeException $e) {
//            return response()->json([
//                'message' => $e->getMessage(),
//                'data' => null
//            ], $e->getCode());
//        } catch (\Exception $e) {
//            return response()->json([
//                'message' => $e->getMessage(),
//                'data' => null
//            ], 500);
//        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Period $period)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Period $period)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePeriodRequest $request, Period $period)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Period $period)
    {
        //
    }
}
