@extends('layouts.app')

@section('content')

<h4>Cadastro de Cartão de Crédito</h4>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
    <a class="btn btn-secondary" href="{{ route('cartao-credito.index') }}">
        <i class="bi bi-arrow-left-square"></i> Voltar 
    </a>
</div>

<form action="{{ route('cartao-credito.store') }}" method="POST" class="row g-3">

    <div class="col-md-4">
        <label for="numero_cartao" class="form-label">Número (4 últimos dígitos)</label>
        <input type="text" class="form-control" name="numero_cartao" id="numero_cartao" value="{{ old('numero_cartao') }}" 
        maxlength="4" pattern="\d{4}" required>
    </div>

    <div class="col-md-8">
        <label for="apelido" class="form-label">Apelido</label>
        <input type="text" class="form-control" name="apelido" id="apelido" value ="{{ old('apelido') }}" >
    </div>

    <div class="col-md-4">
        <label for="valor_limite" class="form-label">Valor limite</label>
        <input type="number" class="form-control" name="valor_limite" id="valor_limite" step="0.01"  placeholder="0,00" 
        value ="{{ old('valor_limite') }}" required>
    </div>

    <div class="col-md-4">
        <label for="dia_vencimento_fatura" class="form-label">Dia vencimento</label>
        <input type="number" class="form-control" name="dia_vencimento_fatura" id="dia_vencimento_fatura" 
        value="{{ old('dia_vencimento_fatura') }}" required>
    </div>

    <div class="col-md-4">
        <label for="dia_fechamento_fatura" class="form-label">Dia fechamento</label>
        <input type="number" class="form-control" name="dia_fechamento_fatura" id="dia_fechamento_fatura" 
        value="{{ old('dia_fechamento_fatura') }}" required>
    </div>

    <div class="col-md-12">
        <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Salvar</button>
    </div>

</form>

@endsection