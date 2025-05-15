@extends('layouts.app')

@section('content')

    <h4><i class="bi bi-credit-card-2-back"></i> Lançamentos do Cartão de Crédito - Competência: {{ $nome_competencia }}</h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
        <a class="btn btn-secondary" href="{{ route('competencia.lancamento.create', $competenciaId) }}">
            <i class="bi bi-arrow-left"></i> Voltar 
        </a>
    </div>
    
    <x-credit-card-release.tabela-total :items="$totalCartoes" :totalGeral="$totalGeral"/>

    <x-credit-card-release.formulario-lancamento :competencia-id="$competenciaId" :cartoes="$cartoes"/>

    <x-credit-card-release.tabela-lancamentos :items="$items" :competencia-id="$competenciaId" :search="$search"/>

@endsection