<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPeriodReleaseRequest;
use App\Http\Requests\EditPeriodReleaseRequest;
use App\Models\PeriodRelease;
use App\Http\Requests\StorePeriodReleaseRequest;
use App\Http\Requests\UpdatePeriodReleaseRequest;
use App\Models\TypeRelease;
use App\Services\Period\PeriodService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PeriodReleaseController extends Controller
{
    protected PeriodService $periodService;

    //injeção de dependência, conceito de SOLID e POO
    public function __construct(PeriodService $periodService)
    {
        $this->periodService = $periodService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $competenciaId)
    {
        $dados['period'] = $this->periodService->getDetalhesCompetenciaById($competenciaId);
        $dados['items'] = PeriodRelease::where('period_id', $competenciaId)
            ->with('typeRelease:id,tipo,descricao')
            ->orderBy('created_at', 'desc')
            ->get();


        $dados['items'] = $dados['items']->map(function (PeriodRelease $item) {
            return [
                'id' => $item->id,
                'valor_total' => number_format($item->valor_total, 2, ',', '.'),
                'observacao' => $item->observacao,
                'situacao' => $item->getSituacaoFormatada(),
                'data_debito_credito' => Carbon::parse($item->data_debito_credito)->format('d/m/Y'),
                'type_release' => [
                    'id' => $item->typeRelease->id,
                    'tipo' => ucfirst($item->typeRelease->tipo),
                    'descricao' => ucfirst($item->typeRelease->descricao),
                ],
            ];
        });
        $dados['competenciaId'] = $competenciaId;

        return view('period-release.create')->with($dados);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePeriodReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = auth()->user()->id;
            $model = PeriodRelease::create($dados);

            $this->lidarComLancamento($model);

            $dados['message'] = 'Lançamento criado com sucesso';

            return back()->with($dados);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function lidarComLancamento(PeriodRelease $model): void
    {

        if ($model->situacao === 'debitado') {
            $period = $model->period;
            $result = $period->saldo_atual - $model->valor_total;

            $period->update(['saldo_atual' => $result]);
        }

        if ($model->situacao === 'creditado') {
            $period = $model->period;
            $result = $period->saldo_atual + $model->valor_total;

            $period->update(['saldo_atual' => $result]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PeriodRelease $periodRelease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditPeriodReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();

            $item = PeriodRelease::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();

            $types = TypeRelease::where('user_id', $user->id)->get();

            return view('period-release.edit')
                ->with([
                    'id' => $item->id,
                    'competenciaId' => $item->period_id,
                    'typeReleaseId' => $item->type_release_id,
                    'valorTotal' => $item->valor_total,
                    'situacao' => $item->situacao,
                    'dataDebitoCredito' => $item->data_debito_credito,
                    'observacao' => $item->observacao,
                    'types' => $types
                ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePeriodReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $item = PeriodRelease::where('user_id', Auth::user()->id)
                ->where('id', $dados['id'])->firstOrFail();
            $item->update($dados);

            $dados['message'] = 'Competência atualizada com sucesso';
            return redirect()->route('competencia.lancamento.create', $item->period_id)->with($dados);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyPeriodReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $model = PeriodRelease::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();
            $model->delete();
            return back()->with(['message' => 'Lancamento excluido com sucesso']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
