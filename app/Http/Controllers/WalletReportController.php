<?php
namespace App\Http\Controllers;
use App\Models\Period;
use App\Models\PeriodRelease;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class WalletReportController extends Controller
{
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

        // return view('wallet-report.index', [
        //     'competencias' => $competencias,
        //     'competenciaSelecionada' => $competenciaSelecionada,
        //     'items' => $items,
        //     'nomeCompetencia' => Carbon::createFromDate($period->ano, $period->mes, 1)->format('m/Y'),
        // ]);

        return view('wallet-report.index', [
            'competencias' => $competenciasSelect,
            'competenciaSelecionada' => $competenciaSelecionada,
            'items' => $items,
            'nomeCompetencia' => $period->getNomeCompetencia(),
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

        $dados = [
            'items' => $items,
            'nomeCompetencia' => $nomeCompetencia,
            'competenciaSelecionada' => $competenciaSelecionada,
        ];

        $pdf = PDF::loadView('wallet-report.pdf', $dados);

        return $pdf->download($nomeArquivo);
    }


}