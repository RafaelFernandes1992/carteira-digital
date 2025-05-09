@extends('layouts.app')

@section('content')

    <h4><i class="bi bi-wallet2"></i> Lançamentos da Carteira - Competência # {{ $competenciaId }} </h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
        <a class="btn btn-secondary" href="{{ route('competencia-carteira.index') }}">    
            <i class="bi bi-arrow-left-square"></i> Voltar 
        </a>
    </div>

    <x-period-release.header
            :saldo_inicial="$period['saldo_inicial'] ?? 0"
            :saldo_atual="$period['saldo_atual'] ?? 0"
            :debitadas_total="$period['debitadas_total'] ?? 0"
            :creditadas_total="$period['creditadas_total'] ?? 0"
            :nao_debitadas_total="$period['nao_debitadas_total'] ?? 0"
            :saldo_atual_previsto="$period['saldo_atual_previsto'] ?? 0"
            :previsao_debitada="$period['previsao_debitada'] ?? 0"
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

    <x-period-release.tabela-lancametos :items="$items" :competencia-id="$competenciaId"/>
@endsection