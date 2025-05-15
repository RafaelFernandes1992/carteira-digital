@extends('layouts.app')

@section('content')

<h4>Edita Lançamento # {{ $id }} do Cartão de Crédito # {{ $creditCardId }}</h4>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
    <a class="btn btn-secondary" href="{{ route('competencia.cartao-credito.lancamento.create', $competenciaId) }}">    
        <i class="bi bi-arrow-left"></i> Voltar 
    </a>
</div>

<form action="{{ route('cartao-credito.lancamento.update', $id) }}" method="POST" class="row g-3 align-items-end">
    
    @method('PUT')
    @csrf

    <div class="col-md-6">
        <label for="descricao" class="form-label">Descrição
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="text" name="descricao" id="descricao" placeholder="Descreva a compra" 
        value="{{ old('descricao', $descricao) }}">
    </div>

    <div class="col-md-2">
        <label for="valor" class="form-label">Valor
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="number" step="0.01" name="valor" id="valor" 
        value="{{ old('valor', $valor) }}">
    </div>

    <div class="col-md-2">
        <label for="quantidade_parcelas" class="form-label">Nº Parcelas
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="number" min="1" max="18" name="quantidade_parcelas" id="quantidade_parcelas" 
        value="{{ old('quantidade_parcelas', $quantidade_parcelas) }}">
    </div>

    <div class="col-md-2">
        <label for="data_compra" class="form-label">Data da Compra
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="date" name="data_compra" id="data_compra" 
        value="{{ old('data_compra', $data_compra) }}">
    </div>

    <div class="col-md-1">
        <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Salvar</button>
    </div>

</form>

@endsection