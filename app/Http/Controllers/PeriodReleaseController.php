<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPeriodReleaseRequest;
use App\Http\Requests\EditPeriodReleaseRequest;
use App\Models\PeriodRelease;
use App\Http\Requests\StorePeriodReleaseRequest;
use App\Http\Requests\UpdatePeriodReleaseRequest;
use App\Models\Period;
use App\Models\TypeRelease;
use App\Services\PeriodService;
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

    public function index()
    {
        //
    }

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
                'type_release' => $item->typeRelease ? [
                    'id' => $item->typeRelease->id,
                    'tipo' => ucfirst($item->typeRelease->tipo),
                    'descricao' => ucfirst($item->typeRelease->descricao),
                ] : null,
            ];
        });
        $dados['competenciaId'] = $competenciaId;
        $period = Period::findOrFail($competenciaId);
        $dados['nome_competencia'] = $period->getNomeCompetencia();

        //dd($dados['items']);

        return view('period-release.create')->with($dados);
    }

    public function store(StorePeriodReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = auth()->user()->id;
            PeriodRelease::create($dados);
            $dados['message'] = 'Lançamento incluído com sucesso!';

            return back()->with($dados);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(EditPeriodReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();

            $item = PeriodRelease::where('user_id', $user->id)
                ->where('id', $dados['id'])
                ->firstOrFail();



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

    public function update(UpdatePeriodReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $item = PeriodRelease::where('user_id', Auth::user()->id)
                ->where('id', $dados['id'])->firstOrFail();
            $item->update($dados);

            $dados['message'] = 'Lançamento atualizado com sucesso!';
            return redirect()->route('competencia.lancamento.create', $item->period_id)->with($dados);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy(DestroyPeriodReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $model = PeriodRelease::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();
            $model->delete();
            return back()->with(['message' => 'Lancamento excluído com sucesso!']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}