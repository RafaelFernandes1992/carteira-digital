@extends('layouts.app')
@section('content')

    <h4>Edita Competência da Carteira</h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
        <a class="btn btn-secondary" href="{{ route('competencia-carteira.index') }}">    
            <i class="bi bi-arrow-left"></i> Voltar 
        </a>
    </div>
    
    <form action="{{ route('competencia-carteira.update', $id) }}" method="POST" class="row g-3">
        @method('PUT')
        @csrf
        <div class="col-md-3">
            <label for="inputmes" class="form-label">Mês</label>
            <select class="form-select" aria-label="Default select example" name="mes" required>
                <option {{ $mes === "01" ? 'selected' : '' }} value="01">Janeiro</option>
                <option {{ $mes === "02" ? 'selected' : '' }} value="02">Fevereiro</option>
                <option {{ $mes === "03" ? 'selected' : '' }} value="03">Março</option>
                <option {{ $mes === "04" ? 'selected' : '' }} value="04">Abril</option>
                <option {{ $mes === "05" ? 'selected' : '' }} value="05">Maio</option>
                <option {{ $mes === "06" ? 'selected' : '' }} value="06">Junho</option>
                <option {{ $mes === "07" ? 'selected' : '' }} value="07">Julho</option>
                <option {{ $mes === "08" ? 'selected' : '' }} value="08">Agosto</option>
                <option {{ $mes === "09" ? 'selected' : '' }} value="09">Setembro</option>
                <option {{ $mes === "10" ? 'selected' : '' }} value="10">Outubro</option>
                <option {{ $mes === "11" ? 'selected' : '' }} value="11">Novembro</option>
                <option {{ $mes === "12" ? 'selected' : '' }} value="12">Dezembro</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="inputano" class="form-label">Ano *</label>
            <input type="number" class="form-control" name="ano" value="{{ old('ano', $ano) }}" required>
        </div>

        <div class="col-md-3">
            <label for="inputsldInicial" class="form-label">Saldo Inicial *</label>
            <input type="number" class="form-control" name="saldo_inicial" step="0.01"  placeholder="0,00" value ="{{ old('saldo_inicial', $saldoInicial) }}" required>
        </div>

        <div class="col-md-4">
            <label for="inputDescricao" class="form-label">Descrição *</label>
            <input type="text" class="form-control" name="descricao" value ="{{ old('descricao', $descricao) }}" >
        </div>

        <div class="col-md-12">
            <label for="inputObs" class="form-label">Observação</label>
            <textarea class="form-control" rows="2" name="observacao">{{ old('observacao', $observacao) }}</textarea>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Salvar</button>
        </div>
    </form>
@endsection