@extends('layouts.app')
@section('content')
    <div class="container">
        <br>
        <h1>Competência da Carteira</h1>
        <br>
        <a href="{{ route('competencia.index') }}">
            <button type="submit" class="btn btn-secondary" name="cancelar" id="cancelar">Cancelar</button>
        </a>
        <br>
        <br>

        <form action="{{ route('competencia.store') }}" method="POST" class="row g-3">

            <div class="col-md-2">
                <label for="inputmes" class="form-label">Mês</label>
                <select class="form-select" aria-label="Default select example" id="inputmes" name="inputmes" required>
                    <option {{ $mesAtual === "01" ? 'selected' : '' }} value="01">Janeiro</option>
                    <option {{ $mesAtual === "02" ? 'selected' : '' }} value="02">Fevereiro</option>
                    <option {{ $mesAtual === "03" ? 'selected' : '' }} value="03">Março</option>
                    <option {{ $mesAtual === "04" ? 'selected' : '' }} value="04">Abril</option>
                    <option {{ $mesAtual === "05" ? 'selected' : '' }} value="05">Maio</option>
                    <option {{ $mesAtual === "06" ? 'selected' : '' }} value="06">Junho</option>
                    <option {{ $mesAtual === "07" ? 'selected' : '' }} value="07">Julho</option>
                    <option {{ $mesAtual === "08" ? 'selected' : '' }} value="08">Agosto</option>
                    <option {{ $mesAtual === "09" ? 'selected' : '' }} value="09">Setembro</option>
                    <option {{ $mesAtual === "10" ? 'selected' : '' }} value="10">Outubro</option>
                    <option {{ $mesAtual === "11" ? 'selected' : '' }} value="11">Novembro</option>
                    <option {{ $mesAtual === "12" ? 'selected' : '' }} value="12">Dezembro</option>
                </select>
            </div>

            <div class="col-md-1">
                <label for="inputano" class="form-label">Ano</label>
                <input type="number" class="form-control" id="inputano" name="inputano" value="{{ $anoAtual }}" required>
            </div>

            <div class="col-md-2">
                <label for="inputsldInicial" class="form-label">Saldo</label>
                <input type="text" class="form-control" id="inputsldInicial" name="inputsldInicial" placeholder="0,00" required>
            </div>

            <div class="col-md-3">
                <label for="inputDescricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="inputDescricao" name="inputDescricao">
            </div>

            <div class="col-md-12">
                <label for="inputObs" class="form-label">Observação</label>
                <textarea class="form-control" id="inputObs" name="inputObs" rows="2" ></textarea>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary" name="gravar" id="gravar">Gravar</button>
            </div>

        </form>
        <br>
    </div>
@endsection