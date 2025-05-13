<?php

namespace App\Services;

use App\Models\Period;
use App\Models\PeriodRelease;
use App\Models\CarRelease;
use App\Models\CreditCardRelease;
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

        /******************* Início da Parte que calcula o dízimo ******************* */

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
        /******************* Fim da Parte que calcula o dízimo ******************* */


        // Soma dos Lançamentos do Carro
        $somaLancamentosCarro = CarRelease::where('period_id', $id)->sum('valor');

        // Soma dos Lançamentos do Cartão de Crédito
        $somaLancamentosCartaoCredito = CreditCardRelease::where('period_id', $id)->sum('valor_parcela');

        $total_despesas = $somaDespesas + $somaLancamentosCarro + $somaLancamentosCartaoCredito;

        $saldo_final =  $saldoInicial + $somaReceitas - $somaInvestimentos - $total_despesas;

        return [
            'saldo_inicial' => number_format((float)$period->saldo_inicial,2, ',', '.'),
            'total_investimentos' => number_format((float)$somaInvestimentos,2, ',', '.'),
            'total_receitas' => number_format((float)$somaReceitas, 2, ',', '.'),
            'dizimo_calculado' => number_format((float)$dizimo_calculado, 2, ',', '.'),
            'total_despesas_carro' => number_format((float)$somaLancamentosCarro, 2, ',', '.'),
            'total_despesas_cartao_credito' => number_format((float)$somaLancamentosCartaoCredito, 2, ',', '.'),
            'total_despesas' => number_format((float)$total_despesas, 2, ',', '.'),
            'saldo_final' => number_format((float)$saldo_final, 2, ',', '.'),
        ]; 
    }

}