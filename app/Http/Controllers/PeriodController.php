<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPeriodRequest;
use App\Http\Requests\EditPeriodRequest;
use App\Models\Period;
use App\Http\Requests\StorePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;
use App\Models\PeriodRelease;
use App\Traits\ValidateScopeTrait;
use Carbon\Carbon;
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
                'saldo_inicial' => number_format($period->saldo_inicial, 2, ',', '.'),
                'saldo_atual' => number_format($period->saldo_atual, 2, ',', '.'),
                'created_at' => Carbon::parse($period->updated_at)->format('d/m/Y H:i:s'),
            ];
        });
        return view('period.index')->with(['items' => $periods]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anoAtual = Carbon::now()->format('Y');
        $mesAtual = Carbon::now()->format('m');
        return view('period.create')
            ->with([
                'anoAtual' => $anoAtual,
                'mesAtual' => $mesAtual
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePeriodRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = auth()->user()->id;
            $dados['saldo_atual'] = $dados['saldo_inicial'];
            Period::create($dados);

            $dados['message'] = 'Competência criada com sucesso';
            return redirect()->route('competencia.index')->with('message', 'Competência criada com sucesso');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function getDetalhesCompetenciaById(string $id): array
    {
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
            'debitadas_total' => number_format((float)$somaDebitadas, 2, ',', '.'),
            'creditadas_total' => number_format((float)$somaCreditadas, 2, ',', '.'),
            'nao_debitadas_total' => number_format((float)$somaNaoDebitadas, 2, ',', '.'),
            'saldo_atual_previsto' => number_format((float)$period->saldo_atual - $somaNaoDebitadas, 2, ',', '.'),
            'previsao_debitada' => number_format((float)$somaDebitadas + $somaNaoDebitadas, 2, ',', '.'),
        ];
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
    public function edit(EditPeriodRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $period = Period::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();

            return view('period.edit')
                ->with([
                    'id' => $period->id,
                    'mes' => $period->mes,
                    'ano' => $period->ano,
                    'saldoInicial' => $period->saldo_inicial,
                    'descricao' => $period->descricao,
                    'observacao' => $period->observacao,
                ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePeriodRequest $request)
    {
        try {
            $dados = $request->validated();
            $period = Period::where('user_id', Auth::user()->id)
                ->where('id', $dados['id'])->firstOrFail();
            $period->update($dados);

            $dados['message'] = 'Competência atualizada com sucesso';
            return redirect()->route('competencia.index')->with($dados);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyPeriodRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $model = Period::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();

            $existePeriodRelease = $model->periodReleases()->exists();
            if ($existePeriodRelease) {
                return back()->withErrors(['error' => 'Não é possível excluir competência com lançamentos!']);
            }

            $model->delete();
            return back()->with(['message' => 'Competencia excluída com sucesso!']);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}