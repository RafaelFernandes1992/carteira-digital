@extends('layouts.app')

@section('content')

<h4>Edita Lançamento # {{ $id }} do Carro # {{ $carId }}</h4>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
    <a class="btn btn-secondary" href="{{ route('competencia.carro.lancamento.create', $competenciaId) }}">    
        <i class="bi bi-arrow-left"></i> Voltar 
    </a>
</div>

<form action="{{ route('carro.lancamento.update', $id) }}" method="POST" class="row g-3 align-items-end">
    
    @method('PUT')
    @csrf

    <div class="col-md-7">
        <label for="descricao" class="form-label">Descrição
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="text" name="descricao" id="descricao" placeholder="Descreva a despesa" 
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
        <label for="data_despesa" class="form-label">Data da Despesa
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="date" name="data_despesa" id="data_despesa" 
        value="{{ old('data_despesa', $data_despesa) }}">
    </div>

    <div class="col-md-1">
        <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Salvar</button>
    </div>

</form>

@endsection