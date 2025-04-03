<?php

namespace App\Services\Period;

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
            'saldo_inicial' => (float)$period->saldo_inicial,
            'saldo_atual' => (float)$period->saldo_atual,
            'debitadas_total' => (float)$somaDebitadas,
            'creditadas_total' => (float)$somaCreditadas,
            'nao_debitadas_total' => (float)$somaNaoDebitadas,
            'saldo_atual_previsto' => (float)$period->saldo_atual - $somaNaoDebitadas,
            'previsao_debitada' => (float)$somaDebitadas + $somaNaoDebitadas,
        ];
    }
}