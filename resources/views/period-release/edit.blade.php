@extends('layouts.app')

@section('content')

<h4>Edita Lançamento # {{ $id }} da Competência # {{ $competenciaId }}</h4>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
    <a class="btn btn-secondary" href="{{ route('competencia.lancamento.create', $competenciaId) }}">    
        <i class="bi bi-arrow-left"></i> Voltar 
    </a>
</div>

<form action="{{ route('competencia.lancamento.update', $id) }}" method="POST" class="row g-3 align-items-end">
    
    @method('PUT')
    @csrf

    <div class="col-md-6">
        <label for="type_release_id" class="form-label">Descrição</label>
        <select class="form-select" aria-label="Default select example" id="type_release_id"
                name="type_release_id" required>
            @foreach($types as $item)
                <option {{ $item->id === $typeReleaseId ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->descricao }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <label for="valor_total" class="form-label">Valor Total</label>
        <input type="number" step="0.01" class="form-control" id="valor_total" name="valor_total"
                value="{{ old('valor_total', $valorTotal) }}">
    </div>

    <div class="col-md-2">
        <label for="situacao" class="form-label">Situação</label>
        <select class="form-select" aria-label="Default select example" id="situacao" name="situacao"
                required>
            <option {{$situacao === 'creditado' ? 'selected' : ''}} value="creditado">Creditado</option>
            <option {{$situacao === 'debitado' ? 'selected' : ''}} value="debitado">Debitado</option>
            <option {{$situacao === 'nao_debitado' ? 'selected' : ''}} value="nao_debitado">Não debitado
            </option>
        </select>
    </div>

    <div class="col-md-2">
        <label for="data_debito_credito" class="form-label">Data</label>
        <input type="date" class="form-control" id="data_debito_credito" name="data_debito_credito"
                value="{{ old('data_debito_credito', $dataDebitoCredito) }}">
    </div>

    <div class="col-md-11">
        <label for="observacao" class="form-label">Observação</label>
        <input type="text" class="form-control" id="observacao" name="observacao"
                value="{{ old('observacao', $observacao) }}">
    </div>

    <div class="col-md-1">
        <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Salvar</button>
    </div>
</form>

@endsection