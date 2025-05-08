<?php

namespace App\Http\Controllers;

use App\Http\Requests\GraficoCompetenciaAnualRequest;
use App\Models\Period;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function totalizarPorCompetenciaAnual(GraficoCompetenciaAnualRequest $request)
    {
        try {
            $dados = $request->validated();
            $ano = $dados['year'];
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
}
