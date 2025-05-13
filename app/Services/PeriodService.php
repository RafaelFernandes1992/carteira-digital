<?php

namespace App\Services;

use App\Models\Period;
use App\Models\PeriodRelease;
use App\Traits\ValidateScopeTrait;

class PeriodService
{
    use ValidateScopeTrait;

    public function getDetalhesCompetenciaById(string $id): array
    {
        $period = Period::find($id);
        $userId = $period->user_id;
        $this->validateScope($userId);
        
        $saldoInicial = Period::find($id)?->saldo_inicial;

        $somaReceitas = PeriodRelease::where('period_id', $id)
            ->where('situacao', 'creditado')
            ->whereHas('typeRelease', function ($query) {
                $query->where('tipo', 'receita');
            })
            ->sum('valor_total');

        $somaInvestimentos = PeriodRelease::where('period_id', $id)
            ->where('situacao', 'debitado')
            ->whereHas('typeRelease', function ($query) {
                $query->where('tipo', 'investimento');
            })
            ->sum('valor_total');
        
        $somaDespesas = PeriodRelease::where('period_id', $id)
            ->where('situacao', 'debitado')
            ->whereHas('typeRelease', function ($query) {
                $query->where('tipo', 'despesa');
            })
            ->sum('valor_total');
        
        $saldo_final =  $saldoInicial + $somaReceitas - $somaInvestimentos - $somaDespesas;

        $somaReceitasIsentas = PeriodRelease::where('period_id', $id)
            ->where('situacao', 'creditado')
            ->whereHas('typeRelease', function ($query) {
                $query->where('tipo', 'receita')
                      ->where('isenta', 1);
            })
            ->sum('valor_total');
        
        $somaDespesasDedutiveis = PeriodRelease::where('period_id', $id)
            ->whereIn('situacao', ['debitado', 'nao_debitado'])
            ->whereHas('typeRelease', function ($query) {
                $query->where('tipo', 'despesa')
                      ->where('dedutivel', 1);
            })
            ->sum('valor_total');
        
        $dizimo_calculado = ($somaReceitas - $somaReceitasIsentas - $somaDespesasDedutiveis) * 0.10;

        return [
            'saldo_inicial' => number_format((float)$period->saldo_inicial,2, ',', '.'),
            'total_investimentos' => number_format((float)$somaInvestimentos,2, ',', '.'),
            'total_despesas' => number_format((float)$somaDespesas, 2, ',', '.'),
            'total_receitas' => number_format((float)$somaReceitas, 2, ',', '.'),
            'saldo_final' => number_format((float)$saldo_final, 2, ',', '.'),
            'dizimo_calculado' => number_format((float)$dizimo_calculado, 2, ',', '.'),
        ]; 
    }

}