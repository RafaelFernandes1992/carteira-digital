@extends('layouts.app')

@section('content')

<h4><i class="bi bi-file-earmark-text"></i> Relatório - Lançamentos da Carteira</h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
        <label class="form-label m-0">Exportar:
        <a href="{{ route('relatorio-carteira.pdf', ['competencia_id' => $competenciaSelecionada]) }}" class="btn btn-danger btn-sm">
            <i class="bi bi-file-earmark-pdf"></i> PDF
        </a></label>

        <form method="GET" class="d-flex justify-content-end align-items-center gap-2">
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
    </div>

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
                        <td>R$ {{ $item['valor_total'] }}</td>
                        <td>{{ $item['situacao'] }}</td>
                        <td>{{ $item['data_debito_credito'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>Despesa</td>
                    <td>Lançamentos Carro</td>
                    <td>R$ {{ $detalhes['total_despesas_carro'] }}</td>
                    <td>Debitado</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Despesa</td>
                    <td>Lançamentos do Cartão de Crédito</td>
                    <td>R$ {{ $detalhes['total_despesas_cartao_credito'] }}</td>
                    <td>Debitado</td>
                    <td>-</td>
                </tr>
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <th colspan="5">Totalizadores</th>
                </tr>
                <tr>
                    <th colspan="2">{{ $detalhes['saldo_inicial'] >= 0 ? '(+)' : '(-)' }} Saldo Inicial</th>
                    <th colspan="3">R$ {{ $detalhes['saldo_inicial'] }}</th>
                </tr>
                <tr>
                    <th colspan="2">(+) Receitas</th>
                    <th colspan="3">R$ {{ $detalhes['total_receitas'] }}</th>
                </tr>
                <tr>
                    <th colspan="2">(-) Despesas</th>
                    <th colspan="3">R$ {{ $detalhes['total_despesas'] }}</th>
                </tr>
                <tr>
                    <th colspan="2">(-) Investimentos</th>
                    <th colspan="3">R$ {{ $detalhes['total_investimentos'] }}</th>
                </tr>
                <tr>
                    <th colspan="2">(=) Saldo Final</th>
                    <th colspan="3">R$ {{ $detalhes['saldo_final'] }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
@else
    <div class="alert alert-warning">
        Nenhum lançamento encontrado para a competência <strong>{{ $nomeCompetencia }}</strong>.
    </div>
@endif

@endsection