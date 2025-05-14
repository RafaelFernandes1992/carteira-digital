@extends('layouts.app')

@section('content')

    <h4><i class="bi bi-wallet2"></i> Lançamentos da Carteira - Competência: {{ $nome_competencia }} </h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
        <a class="btn btn-secondary" href="{{ route('competencia-carteira.index') }}">    
            <i class="bi bi-arrow-left-square"></i> Voltar 
        </a>
    </div>

    <x-period-release.header
            :saldo_inicial="$period['saldo_inicial'] ?? 0"
            :total_investimentos="$period['total_investimentos'] ?? 0"
            :total_despesas="$period['total_despesas'] ?? 0"
            :total_receitas="$period['total_receitas'] ?? 0"
            :saldo_final="$period['saldo_final'] ?? 0"
            :dizimo_calculado="$period['dizimo_calculado'] ?? 0"
    />
    <br>

    <div class="d-flex justify-content-start gap-3">
        <form action="{{ route('competencia-carteira.rotineiros', $competenciaId) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-info">
               <i class="bi bi-floppy"></i> Incluir lançamentos rotineiros
            </button>
        </form>
    </div>

    <x-period-release.formulario-lancamento :competencia-id="$competenciaId"/>

    <x-period-release.tabela-lancametos 
        :items="$items" 
        :competencia-id="$competenciaId"
        :total_despesas_carro="$period['total_despesas_carro'] ?? 0"
        :total_despesas_cartao_credito="$period['total_despesas_cartao_credito'] ?? 0"
    />
@endsection