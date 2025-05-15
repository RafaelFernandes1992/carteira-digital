@extends('layouts.app')

@section('content')

    <h4><i class="bi bi-car-front"></i> Lançamentos do Carro - Competência: {{ $nome_competencia }}</h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
        <a class="btn btn-secondary" href="{{ route('competencia.lancamento.create', $competenciaId) }}">
            <i class="bi bi-arrow-left"></i> Voltar 
        </a>
    </div>
    
    <x-car-release.tabela-total :items="$totalCarros" :totalGeral="$totalGeral"/>

    <x-car-release.formulario-lancamento :competencia-id="$competenciaId" :carros="$carros"/>

    <x-car-release.tabela-lancamentos :items="$items" :competencia-id="$competenciaId" :search="$search"/>


@endsection