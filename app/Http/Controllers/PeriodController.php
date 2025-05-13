<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRoutineItemsRequest;
use App\Http\Requests\DestroyPeriodRequest;
use App\Http\Requests\EditPeriodRequest;
use App\Models\Period;
use App\Http\Requests\StorePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;
use App\Models\PeriodRelease;
use App\Models\TypeRelease;
use App\Traits\ValidateScopeTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\PeriodService;

class PeriodController extends Controller
{
    use ValidateScopeTrait;
    public function addRoutineItems(AddRoutineItemsRequest $request)
    {
        try {
            $count = 0;
            DB::beginTransaction();
            $dados = $request->validated();
            $user = Auth::user();
            $itensRotineiros = TypeRelease
                ::where('user_id', $user->id)
                ->where('rotineira', true)
                ->get();

            foreach ($itensRotineiros as $item) {
                $dadosParaPeriodRelease = [
                    'valor_total' => 0,
                    'data_debito_credito' => Carbon::now(),
                    'situacao' => $this->getSituacaoByTipo($item->tipo),
                    'user_id' => $user->id,
                    'period_id' => $dados['id'],
                    'type_release_id' => $item->id,
                ];
                $this->criaPeriodReleaseSeNaoExiste($dadosParaPeriodRelease, $count);
            }



            DB::commit();

            
            if ($count > 0) {
                $message = 'Itens rotineiros incluídos com sucesso!';
                return redirect()->route('competencia.lancamento.create', $dados['id'])
                ->with('message', $message);
            }

            if ($count === 0) {
                $messageWarning = 'Nenhum item rotineiro para incluir.';
                return redirect()->route('competencia.lancamento.create', $dados['id'])
                ->with('messageWarning', $messageWarning);
            }


        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function criaPeriodReleaseSeNaoExiste(array $data, int &$count): void
    {
        $existe = PeriodRelease
            ::where('user_id', $data['user_id'])
            ->where('period_id', $data['period_id'])
            ->where('type_release_id', $data['type_release_id'])
            ->exists();
        if (!$existe) {
            $count++;
            PeriodRelease::create($data);
        }
    }

    private function getSituacaoByTipo(string $tipo): string
    {
        if ($tipo === 'receita') {
            return 'creditado';
        }
        return 'nao_debitado';
    }

    protected PeriodService $periodService;

    //injeção de dependência, conceito de SOLID e POO
    public function __construct(PeriodService $periodService)
    {
        $this->periodService = $periodService;
    }



    public function index()
    {
        $user = Auth::user();
        $periods = Period::where('user_id', $user->id)->get();
        $periods = $periods->map(function ($period) {
            $competencia = Carbon::createFromDate($period->ano, $period->mes, 1);

            $detalhes = $this->periodService->getDetalhesCompetenciaById($period->id);

            return [
                'id' => $period->id,
                'competencia' => $competencia->format('m/Y'),
                'descricao' => $period->descricao,
                'saldo_inicial' => number_format($period->saldo_inicial, 2, ',', '.'),
                'saldo_final' => $detalhes['saldo_final'], // já vem formatado pelo service
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
            Period::create($dados);

            $dados['message'] = 'Competência criada com sucesso';
            return redirect()->route('competencia-carteira.index')->with('message', 'Competência criada com sucesso');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
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
            return redirect()->route('competencia-carteira.index')->with($dados);

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