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

        // Buscar todas as competências do usuário ordenadas por ano/mes (mais recentes primeiro)
        $competencias = Period::where('user_id', $user->id)
            ->orderByDesc('ano')
            ->orderByDesc('mes')
            ->get();

        // Criar lista de opções para select (id => "nome da competência")
        $competenciasSelect = $competencias->mapWithKeys(fn($period) => [
            $period->id => $period->getNomeCompetencia()
        ]);

        // Se não houver nenhuma competência, retornar com erro
        if ($competencias->isEmpty()) {
            return back()->with('error', 'Nenhuma competência encontrada.');
        }

        // Pega ID da competência selecionada (vinda da requisição ou define a atual automaticamente)
        $competenciaSelecionada = $request->input('competencia_id');

        if (!$competenciaSelecionada) {
            // Define como padrão a competência do mês atual, se existir
            $now = now(); // mesmo que Carbon::now()
            $competenciaAtual = $competencias->firstWhere(fn($p) => $p->ano == $now->year && $p->mes == $now->month);

            $competenciaSelecionada = $competenciaAtual?->id ?? $competencias->first()->id;
        }

        // Verifica se a competência pertence ao usuário
        $period = $competencias->firstWhere('id', $competenciaSelecionada);
        if (!$period) {
            abort(403, 'Recurso não pertence ao usuário autenticado');
        }

        // Carrega os lançamentos dessa competência
        $items = PeriodRelease::where('period_id', $period->id)
            ->with('typeRelease:id,tipo,descricao')
            ->orderByDesc('created_at')
            ->get()
            ->map(function (PeriodRelease $item) {
                return [
                    'id' => $item->id,
                    'valor_total' => number_format($item->valor_total, 2, ',', '.'),
                    'observacao' => $item->observacao,
                    'situacao' => $item->getSituacaoFormatada(),
                    'data_debito_credito' => optional(Carbon::parse($item->data_debito_credito))->format('d/m/Y'),
                    'type_release' => $item->typeRelease ? [
                        'id' => $item->typeRelease->id,
                        'tipo' => ucfirst($item->typeRelease->tipo),
                        'descricao' => ucfirst($item->typeRelease->descricao),
                    ] : null,
                ];
            });

        // Buscar dados agregados da competência
        $detalhes = $this->periodService->getDetalhesCompetenciaById($period->id);

        return view('wallet-report.index', [
            'competencias' => $competenciasSelect,
            'competenciaSelecionada' => $period->id,
            'items' => $items,
            'nomeCompetencia' => $period->getNomeCompetencia(),
            'detalhes' => $detalhes,
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $user = auth()->user();

        // Buscar todas as competências do usuário
        $competencias = Period::where('user_id', $user->id)
            ->orderByDesc('ano')
            ->orderByDesc('mes')
            ->get();

        // Verifica se o usuário tem competências
        if ($competencias->isEmpty()) {
            return back()->with('error', 'Nenhuma competência encontrada.');
        }

        // Tenta obter o ID da competência selecionada
        $competenciaSelecionada = $request->input('competencia_id');

        if (!$competenciaSelecionada) {
            $now = now();

            // Tenta encontrar a competência atual (ano/mes) entre as do usuário
            $competenciaAtual = $competencias->firstWhere(fn($p) => $p->ano == $now->year && $p->mes == $now->month);
            $competenciaSelecionada = $competenciaAtual?->id ?? $competencias->first()->id;
        }

        // Garante que a competência pertence ao usuário autenticado
        $period = $competencias->firstWhere('id', $competenciaSelecionada);

        if (!$period) {
            abort(403, 'Recurso não pertence ao usuário autenticado');
        }

        // Busca lançamentos da competência
        $items = PeriodRelease::where('period_id', $period->id)
            ->with('typeRelease:id,tipo,descricao')
            ->orderByDesc('created_at')
            ->get()
            ->map(function (PeriodRelease $item) {
                return [
                    'id' => $item->id,
                    'valor_total' => number_format($item->valor_total, 2, ',', '.'),
                    'observacao' => $item->observacao,
                    'situacao' => $item->getSituacaoFormatada(),
                    'data_debito_credito' => optional(Carbon::parse($item->data_debito_credito))->format('d/m/Y'),
                    'type_release' => $item->typeRelease ? [
                        'id' => $item->typeRelease->id,
                        'tipo' => ucfirst($item->typeRelease->tipo),
                        'descricao' => ucfirst($item->typeRelease->descricao),
                    ] : null,
                ];
            });

        // Nome do arquivo e nome da competência
        $nomeCompetencia = Carbon::createFromDate($period->ano, $period->mes, 1)->format('m-Y');
        $nomeArquivo = "relatorio_carteira_{$nomeCompetencia}.pdf";

        // Busca os detalhes agregados
        $detalhes = $this->periodService->getDetalhesCompetenciaById($period->id);

        // Monta os dados para a view
        $dados = [
            'items' => $items,
            'nomeCompetencia' => $nomeCompetencia,
            'competenciaSelecionada' => $period->id,
            'detalhes' => $detalhes,
        ];

        // Gera e retorna o PDF
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