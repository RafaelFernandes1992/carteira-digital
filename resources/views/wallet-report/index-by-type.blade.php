@extends('layouts.app')

@section('content')
    <h4><i class="bi bi-file-earmark-text"></i> Relatório - Anual por Tipo de Lançamento</h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
        <label class="form-label m-0">Baixar:
            <a href="{{ route('relatorio-carteira.anual-por-tipo.pdf', ['ano' => $ano, 'tipo' => $tipo, 'descricao' => $descricaoId]) }}" 
                class="btn btn-danger btn-sm" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> PDF
            </a>
        </label>
    </div>

    <form method="GET" action="{{ route('relatorio-carteira.anual-por-tipo') }}" class="row g-3 mb-4">

        <div class="col-md-2">
            <label class="form-label">Ano</label>
            <select name="ano" class="form-select" 
                onchange="
                    this.form.tipo.value = '';
                    this.form.descricao.value = '';
                    this.form.submit();
                " required>
                <option value="">Selecione...</option>
                @foreach($anos as $item)
                    <option value="{{ $item }}" {{ ($ano == $item) ? 'selected' : '' }}>
                        {{ $item }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="col-md-4">
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

        <div class="col-md-6">
            <label class="form-label">Descrição</label>
            <select name="descricao" class="form-select" onchange="this.form.submit()">
                <option value="">Todas as descrições</option>
                @foreach($descricoes as $desc)
                    <option value="{{ $desc->id }}" {{ ($descricaoId == $desc->id) ? 'selected' : '' }}>
                        {{ $desc->descricao }}
                    </option>
                @endforeach
            </select>
        </div>
        
    </form>

    @if($lancamentos && count($lancamentos) > 0)
            @if($ano && $tipo)
        <div class="alert alert-info">
            Lançamentos referentes ao ano de <strong>{{ $ano }}</strong>, do tipo <strong>{{ $tipo }}</strong> 
            @if($descricaoId)
                com descrição <strong>{{ $descricoes->where('id', $descricaoId)->first()->descricao ?? '' }}</strong>.
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
                </tr>
            </thead>
            <tbody>
                @foreach($lancamentos as $item)
                    <tr>
                        <td>{{ $item['competencia'] }}</td>
                        <td>{{ $item['data_debito_credito'] }}</td>
                        <td>{{ $item['descricao'] }}</td>
                        <td>R$ {{ $item['valor_total'] }}</td>
                        <td>{{ $item['situacao'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @elseif($ano && $tipo && $descricaoId)
        <div class="alert alert-warning">
            Nenhum lançamento encontrado.
        </div>

    @elseif($ano && $tipo)
        <div class="alert alert-warning">
            Nenhum lançamento encontrado.
        </div>

    @endif

@endsection 