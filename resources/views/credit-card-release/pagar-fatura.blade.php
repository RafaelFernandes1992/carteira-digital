@extends('layouts.app')

@section('content')
    <h4>Informa Pagamento da Fatura - Competência: {{ $nomeCompetencia }} - Cartão: {{ $nomeCartao }}</h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
        <a class="btn btn-secondary" href="{{ route('competencia.cartao-credito.lancamento.create', $competenciaId) }}">    
            <i class="bi bi-arrow-left"></i> Voltar 
        </a>
    </div>

    <form method="POST" action="{{ route('cartao-credito.pagar-fatura') }}" class="row g-3 align-items-end">
        @csrf
        <input type="hidden" name="competencia_id" value="{{ $competenciaId }}">
        <input type="hidden" name="credit_card_id" value="{{ $creditCardId }}">

        <div class="col-md-3">
            <label for="data_pagamento_fatura" class="form-label">Data do Pagamento</label>
            <input type="date" name="data_pagamento_fatura" id="data_pagamento_fatura" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Valor Calculado para Fatura</label>
            <input type="number" step="0.01" class="form-control" value="{{ $valor }}" readonly disabled>
        </div>

        <div class="col-md-3">
            <label class="form-label">Valor Pago Efetivamente</label>
            <input type="number" step="0.01" name="valor_pago_fatura" id="valor_pago_fatura"  class="form-control" value="{{ $valor }}" required>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-floppy"></i> Salvar
            </button>
        </div>

    </form>
@endsection