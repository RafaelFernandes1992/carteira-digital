@extends('layouts.app')

@section('content')

<h4>Cadastro de Carro</h4>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
    <a class="btn btn-secondary" href="{{ route('carro.index') }}">
        <i class="bi bi-arrow-left-square"></i> Voltar 
    </a>
</div>

<form action="{{ route('carro.store') }}" method="POST" class="row g-3">

    <div class="col-md-4">
        <label for="apelido" class="form-label">Apelido</label>
        <input type="text" class="form-control" name="apelido" id="apelido" value ="{{ old('apelido') }}" >
    </div>

    <div class="col-md-4">
        <label for="renavam" class="form-label">Renavam</label>
        <input type="text" class="form-control" name="renavam" id="renavam" value="{{ old('renavam') }}" 
        maxlength="11" pattern="\d{11}" required>
    </div>

    <div class="col-md-4">
        <label for="placa" class="form-label">Placa</label>
        <input type="text" class="form-control" name="placa" id="placa" value="{{ old('placa') }}" 
        maxlength="7" required>
    </div>

    <div class="col-md-4">
        <label for="marca" class="form-label">Marca</label>
        <input type="text" class="form-control" name="marca" id="marca" value ="{{ old('marca') }}" >
    </div>

    <div class="col-md-4">
        <label for="modelo" class="form-label">Modelo</label>
        <input type="text" class="form-control" name="modelo" id="modelo" value ="{{ old('modelo') }}" >
    </div>

    <div class="col-md-4">
        <label for="data_aquisicao" class="form-label">Data aquisição</label>
        <input type="date" class="form-control" name="data_aquisicao" id="data_aquisicao" 
        value="{{ old('data_aquisicao') }}" required>
    </div>

    <div class="col-md-12">
        <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Salvar</button>
    </div>

</form>

@endsection