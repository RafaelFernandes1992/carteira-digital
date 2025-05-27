@extends('layouts.app')

@section('content')
<h4><i class="bi bi-file-earmark-text"></i> Relatório por Tipo de Lançamento</h4>

<form method="GET" action="{{ route('relatorio-carteira.anual-por-tipo') }}" class="row g-3 mb-4">
    <div class="col-md-3">
        <label class="form-label">Ano</label>
        <select name="ano" class="form-select" required>
            <option value="">Selecione...</option>
            @foreach($anos as $item)
                <option value="{{ $item }}" {{ ($ano == $item) ? 'selected' : '' }}>
                    {{ $item }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Tipo de Lançamento</label>
        <select name="tipo" class="form-select" onchange="this.form.submit()" required>
            <option value="">Selecione...</option>
            @foreach($tipos as $key => $value)
                <option value="{{ $key }}" {{ ($tipo == $key) ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Descrição</label>
        <select name="descricao" class="form-select">
            <option value="">{{ $tipo ? 'Todas as descrições' : 'Selecione o tipo primeiro' }}</option>
            @foreach($descricoes as $desc)
                <option value="{{ $desc->id }}" {{ ($descricaoId == $desc->id) ? 'selected' : '' }}>
                    {{ $desc->descricao }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-search"></i> Buscar
        </button>
    </div>
</form>

    @if($lancamentos && count($lancamentos) > 0)
            @if($ano && $tipo)
        <div class="alert alert-info">
            Mostrando <strong>{{ $tipo }}</strong> para o ano de <strong>{{ $ano }}</strong>
            @if($descricaoId)
                e descrição <strong>{{ $descricoes->where('id', $descricaoId)->first()->descricao ?? '' }}</strong>
            @endif
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Competência</th>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Situação</th>
                    <th>Observação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lancamentos as $item)
                    <tr>
                        <td>{{ $item->period->mes }}/{{ $item->period->ano }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->data_debito_credito)->format('d/m/Y') }}</td>
                        <td>{{ $item->typeRelease->descricao ?? '-' }}</td>
                        <td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                        <td>{{ $item->situacao }}</td>
                        <td>{{ $item->observacao }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@elseif($ano && $tipo && $descricaoId)
    <div class="alert alert-warning">
        Nenhum lançamento encontrado.
    </div>
@endif
@endsection