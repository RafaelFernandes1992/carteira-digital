@extends('layouts.app')

@section('content')

    <h4>Lançamentos do Cartão de Crédito - Competência # {{ $competenciaId }} </h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
        <a class="btn btn-secondary" href="{{ route('competencia-carteira.index') }}">Cancelar</a>
    </div>

    <div class="row g-3 align-items-end">
        <div class="col-md-2">
            <label class="form-label">Total Geral</label>
            <input type="text" class="form-control" value="{{ $totalGeral }}" disabled>
        </div>
    </div>

    <x-credit-card-release.tabela-total :items="$totalCartoes" />
    <br>

    <x-credit-card-release.formulario-lancamento :competencia-id="$competenciaId" :cartoes="$cartoes"/>

    <x-credit-card-release.tabela-lancamentos :items="$items" :competencia-id="$competenciaId" :search="$search" />
@endsection