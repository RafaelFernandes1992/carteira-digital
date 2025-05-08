@extends('layouts.app')

@section('content')

    <h4>Lançamentos do Cartão de Crédito - Competência # {{ $competenciaId }} </h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
        <a class="btn btn-secondary" href="{{ route('competencia.lancamento.create', $competenciaId) }}">
            <i class="bi bi-arrow-left-circle"></i> Cancelar
        </a>
    </div>

    <x-credit-card-release.tabela-total :items="$totalCartoes" :totalGeral="$totalGeral"/>

    <x-credit-card-release.formulario-lancamento :competencia-id="$competenciaId" :cartoes="$cartoes"/>

    <x-credit-card-release.tabela-lancamentos :items="$items" :competencia-id="$competenciaId" :search="$search" />
@endsection