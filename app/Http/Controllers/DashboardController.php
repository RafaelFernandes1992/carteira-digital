<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\SearchAnoRequest;
use App\Models\Period;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function totalizarPorCompetenciaAnual(SearchAnoRequest $request)
    {
        try {
            $dados = $request->validated();
            $ano = $dados['year'];

            $totalizadores = $this->calculaCompetenciasPorAno($ano);
            return response()->json([
                'message' => 'Registros encontrados',
                'data' => $totalizadores
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function quantitativosCards(SearchAnoRequest $request)
    {
        try {
            $dados = $request->validated();
            $ano = $dados['year'];
            $user = Auth::user();

            $totalizadores = $this->calculaCompetenciasPorAno($ano);
            $totalCompetencia = Period::where('user_id', $user->id)
                ->where('ano', $ano)->count();

            $totalCompetencia = $totalCompetencia > 0 ? $totalCompetencia : '-';

            $totalCards = [
                'total_competencias' => $totalCompetencia,
                'total_investimentos' => Helper::formatToCurrency(array_sum($totalizadores['investimento'])),
                'total_receitas' => Helper::formatToCurrency(array_sum($totalizadores['receita'])),
                'total_despesas' => Helper::formatToCurrency(array_sum($totalizadores['despesa'])),
            ];

            return response()->json([
                'message' => 'Registros encontrados',
                'data' => $totalCards
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    private function calculaCompetenciasPorAno($ano): array
    {
        $user = Auth::user();
        $arrayAnos = ['jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez'];

        $totalizadores = [
            'investimento' => array_fill_keys($arrayAnos, 0),
            'despesa' => array_fill_keys($arrayAnos, 0),
            'receita' => array_fill_keys($arrayAnos, 0),
        ];

        $result = Period::where('ano', $ano)
            ->where('user_id', $user->id)
            ->with('periodReleases.typeRelease')
            ->get();

        foreach ($result as $period) {
            foreach ($period->periodReleases as $release) {
                $mes = $period->mes;
                $mesIndex = $arrayAnos[$mes - 1];
                $tipo = strtolower($release->typeRelease->tipo);

                if (isset($totalizadores[$tipo])) {
                    $totalizadores[$tipo][$mesIndex] += (float) $release->valor_total;
                }
            }
        }

        foreach ($totalizadores as &$tipo) {
            $tipo = array_values($tipo);
        }
        return $totalizadores;
    }
}
