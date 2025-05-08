@extends('layouts.app')
@section('content')

    <h4>Edita Tipo de Lançamento</h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
        <a class="btn btn-secondary" href="{{ route('tipo-lancamento.index') }}">    
            <i class="bi bi-arrow-left-circle"></i> Cancelar
        </a>
    </div>
    
    <form action="{{ route('tipo-lancamento.update', $id) }}" method="POST" class="row g-3">
        @method('PUT')

        <div class="col-md-2">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" aria-label="Default select example" id="tipo" name="tipo" required>
                <option {{$tipo === 'receita' ? 'selected' : ''}} value="receita">Receita</option>
                <option {{$tipo === 'despesa' ? 'selected' : ''}} value="despesa">Despesa</option>
                <option {{$tipo === 'investimento' ? 'selected' : ''}} value="investimento">Investimento</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" name="descricao" value ="{{ old('descricao', $descricao) }}" required>
        </div>

        <div class="col-md-2">
            <label for="rotineira" class="form-label">Rotineira</label>
            <select class="form-select" aria-label="Default select example" id="rotineira" name="rotineira" required>
                <option {{$rotineira === 1 ? 'selected' : ''}} value="1">Sim</option>
                <option {{$rotineira === 0 ? 'selected' : ''}} value="0">Não</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="isenta" class="form-label">Isenta</label>
            <select class="form-select" aria-label="Default select example" id="isenta" name="isenta">
                <option {{$isenta === 1 ? 'selected' : ''}} value="1">Sim</option>
                <option {{$isenta === 0 ? 'selected' : ''}} value="0">Não</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="dedutivel" class="form-label">Dedutível</label>
            <select class="form-select" aria-label="Default select example" id="dedutivel" name="dedutivel">
                <option {{$dedutivel === 1 ? 'selected' : ''}} value="1">Sim</option>
                <option {{$dedutivel === 0 ? 'selected' : ''}} value="0">Não</option>
            </select>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-primary" name="gravar">Salvar Alterações</button>
        </div>
    </form>
@endsection