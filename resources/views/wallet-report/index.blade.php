@extends('layouts.app')

@section('content')

<h4><i class="bi bi-file-earmark-text"></i> Relatório - Lançamentos da Carteira</h4>

<a href="{{ route('relatorio-carteira.pdf', ['competencia_id' => $competenciaSelecionada]) }}" class="btn btn-danger mb-3">
    <i class="bi bi-file-earmark-pdf"></i> Baixar PDF
</a>

<form method="GET" class="d-flex justify-content-end align-items-center gap-2 mb-3">
    <label for="competencia_id" class="form-label m-0">Competência:</label>

    <select name="competencia_id" id="competencia_id" class="form-select" style="width: auto; min-width: 250px;" 
        onchange="this.form.submit()" >
        @foreach($competencias as $id => $nome)
            <option value="{{ $id }}" {{ $id == $competenciaSelecionada ? 'selected' : '' }}>
                {{ $nome }}
            </option>
        @endforeach
    </select>
</form>

@if(count($items) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Situação</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item['type_release']['tipo'] ?? '-' }}</td>
                        <td>{{ $item['type_release']['descricao'] ?? '-' }}</td>
                        <td>{{ $item['valor_total'] }}</td>
                        <td>{{ $item['situacao'] }}</td>
                        <td>{{ $item['data_debito_credito'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-warning">
        Nenhum lançamento encontrado para a competência <strong>{{ $nomeCompetencia }}</strong>.
    </div>
@endif

@endsection