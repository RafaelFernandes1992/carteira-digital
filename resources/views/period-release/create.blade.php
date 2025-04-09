@extends('layouts.app')

@section('content')
    <h3>Lançamentos da competência</h3>
    <br>
    <x-period-release.competencia-header
            :saldo_inicial="$period['saldo_inicial'] ?? 0"
            :saldo_atual="$period['saldo_atual'] ?? 0"
            :debitadas_total="$period['debitadas_total'] ?? 0"
            :creditadas_total="$period['creditadas_total'] ?? 0"
            :nao_debitadas_total="$period['nao_debitadas_total'] ?? 0"
            :saldo_atual_previsto="$period['saldo_atual_previsto'] ?? 0"
            :previsao_debitada="$period['previsao_debitada'] ?? 0"
    />
{{--    todo: colocar o erros em layout/app.blade.php--}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <x-period-release.formulario-lancamento :competencia-id="$competenciaId" />
    <x-period-release.tabela-lancametos :items="$items" />
@endsection