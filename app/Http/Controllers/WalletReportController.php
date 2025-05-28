<?php
namespace App\Http\Controllers;
use App\Models\Period;
use App\Models\PeriodRelease;
use App\Models\TypeRelease;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\PeriodService;

class WalletReportController extends Controller
{
    private PeriodService $periodService;

    public function __construct(PeriodService $periodService)
    {
        $this->periodService = $periodService;
    }

    public function index(Request $request)
    {
        
        $user = auth()->user();

        // Buscar todas as competências do usuário
        $competencias = Period::where('user_id', $user->id)
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        $competenciasSelect = $competencias->mapWithKeys(function ($period) {
            return [$period->id => $period->getNomeCompetencia()];
        });


        $now = Carbon::now();

        // Buscar competência atual (mês/ano igual ao atual)
        $competenciaAtual = Period::where('ano', $now->year)
            ->where('mes', $now->month)
            ->first();

        $competenciaSelecionada = $request->input('competencia_id')
            ?? ($competenciaAtual ? $competenciaAtual->id : ($competencias->first()['id'] ?? null));

        if (!$competenciaSelecionada) {
            return back()->with('error', 'Nenhuma competência encontrada.');
        }

        // Dados da competência selecionada
        $period = Period::findOrFail($competenciaSelecionada);

        // Lançamentos da competência
        $items = PeriodRelease::where('period_id', $competenciaSelecionada)
            ->with('typeRelease:id,tipo,descricao')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function (PeriodRelease $item) {
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

        $detalhes = $this->periodService->getDetalhesCompetenciaById($competenciaSelecionada);

        return view('wallet-report.index', [
            'competencias' => $competenciasSelect,
            'competenciaSelecionada' => $competenciaSelecionada,
            'items' => $items,
            'nomeCompetencia' => $period->getNomeCompetencia(),
            'detalhes' => $detalhes,
        ]);
    }

    public function downloadPdf(Request $request)
    {
        
        $user = auth()->user();

        // Buscar competências
        $competencias = Period::where('user_id', $user->id)
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        $now = Carbon::now();

        $competenciaAtual = Period::where('ano', $now->year)
            ->where('mes', $now->month)
            ->first();

        $competenciaSelecionada = $request->input('competencia_id')
            ?? ($competenciaAtual ? $competenciaAtual->id : ($competencias->first()->id ?? null));

        
        if (!$competenciaSelecionada) {
            return back()->with('error', 'Nenhuma competência encontrada.');
        }

        $period = Period::findOrFail($competenciaSelecionada);

        $items = PeriodRelease::where('period_id', $competenciaSelecionada)
            ->with('typeRelease:id,tipo,descricao')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function (PeriodRelease $item) {
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

        $nomeCompetencia = Carbon::createFromDate($period->ano, $period->mes, 1)->format('m-Y');
        $nomeArquivo = "relatorio_carteira_{$nomeCompetencia}.pdf";
        $detalhes = $this->periodService->getDetalhesCompetenciaById($competenciaSelecionada);


        $dados = [
            'items' => $items,
            'nomeCompetencia' => $nomeCompetencia,
            'competenciaSelecionada' => $competenciaSelecionada,
            'detalhes' => $detalhes,
        ];

        $pdf = PDF::loadView('wallet-report.pdf', $dados);

        return $pdf->download($nomeArquivo);
    }

    public function reportByType(Request $request)
    {
        $user = auth()->user();

        // Buscar filtros do formulário
        $ano = $request->input('ano');
        $tipo = $request->input('tipo');
        $descricaoId = $request->input('descricao');

        // Carregar anos disponíveis
        $anos = Period::where('user_id', $user->id)
                    ->selectRaw('DISTINCT ano')
                    ->orderBy('ano', 'desc')
                    ->pluck('ano');

        // Tipos fixos
        $tipos = [
            'Receita' => 'Receita',
            'Despesa' => 'Despesa',
            'Investimento' => 'Investimento',
        ];

        // Carregar descrições conforme o tipo selecionado
        $descricoes = [];
        if ($tipo) {
            $descricoes = TypeRelease::where('tipo', $tipo)
                                    ->orderBy('descricao')
                                    ->get();
        }

        // Consultar lançamentos se ano e tipo estão preenchidos
        $lancamentos = collect(); // Começa vazio como coleção

        if ($ano && $tipo) {
            $query = PeriodRelease::with(['period', 'typeRelease'])
                ->whereHas('period', function ($q) use ($user, $ano) {
                    $q->where('user_id', $user->id)
                    ->where('ano', $ano);
                })
                ->whereHas('typeRelease', function ($q) use ($tipo) {
                    $q->where('tipo', $tipo);
                });

            // Se descrição foi selecionada, aplica o filtro
            if (!empty($descricaoId)) {
                $query->where('type_release_id', $descricaoId);
            }

            $lancamentos = $query->orderBy('data_debito_credito')->get();

            // Aplicar o map para formatar os dados
            $lancamentos = $lancamentos->map(function (PeriodRelease $item) {
                return [
                    'id' => $item->id,
                    'competencia' => sprintf('%02d/%d', $item->period->mes, $item->period->ano),
                    'data_debito_credito' => \Carbon\Carbon::parse($item->data_debito_credito)->format('d/m/Y'),
                    'descricao' => $item->typeRelease->descricao ?? '-',
                    'valor_total' => number_format($item->valor_total, 2, ',', '.'),
                    'situacao' => $item->getSituacaoFormatada(),
                    'observacao' => $item->observacao,
                ];
            });
        }

        return view('wallet-report.index-by-type', compact(
            'anos', 'tipos', 'descricoes', 
            'ano', 'tipo', 'descricaoId', 
            'lancamentos'
        ));
    }

    public function anualPorTipoDownloadPdf(Request $request)
    {
        $user = auth()->user();

        $ano = $request->input('ano');
        $tipo = $request->input('tipo');
        $descricaoId = $request->input('descricao');

        if (!$ano || !$tipo) {
            return back()->with('error', 'Ano e Tipo de lançamento são obrigatórios para gerar o PDF.');
        }

        // Buscar descrições possíveis para exibir no PDF
        $descricoes = TypeRelease::where('tipo', $tipo)
                        ->where('user_id', $user->id)
                        ->orderBy('descricao')
                        ->get();

        // Consultar os lançamentos com os filtros aplicados
        $query = PeriodRelease::whereHas('period', function ($q) use ($user, $ano) {
                $q->where('user_id', $user->id)
                ->where('ano', $ano);
            })
            ->whereHas('typeRelease', function ($q) use ($tipo) {
                $q->where('tipo', $tipo);
            })
            ->with(['period', 'typeRelease']);

        if ($descricaoId) {
            $query->where('type_release_id', $descricaoId);
        }

        $lancamentos = $query->orderBy('data_debito_credito')->get();

        // Formatar os lançamentos da mesma forma do outro método
        $items = $lancamentos->map(function (PeriodRelease $item) {
            return [
                'id' => $item->id,
                'competencia' => sprintf('%02d/%d', $item->period->mes, $item->period->ano),
                'data_debito_credito' => \Carbon\Carbon::parse($item->data_debito_credito)->format('d/m/Y'),
                'descricao' => $item->typeRelease->descricao ?? '-',
                'valor_total' => number_format($item->valor_total, 2, ',', '.'),
                'situacao' => $item->getSituacaoFormatada(),
                'observacao' => $item->observacao,
            ];
        });

        // Nome do arquivo
        $nomeArquivo = "relatorio_anual_por_tipo_{$ano}_{$tipo}.pdf";

        // Dados para a view
        $dados = [
            'ano' => $ano,
            'tipo' => ucfirst($tipo),
            'descricaoId' => $descricaoId,
            'descricoes' => $descricoes,
            'items' => $items,
        ];

        // Gerar o PDF
        $pdf = PDF::loadView('wallet-report.by-type-pdf', $dados);

        return $pdf->download($nomeArquivo);
    }



}