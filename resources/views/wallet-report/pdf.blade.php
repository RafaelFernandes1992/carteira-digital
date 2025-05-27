<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório - Lançamentos da Carteira - {{ $nomeCompetencia }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background-color: #eee; }
        td { vertical-align: top; }
        h2 {
            color: #007bff !important;
            font-weight: bold;
        }
    </style>
</head>
<body>


    <div>
        <h2>Carteira Digital</h2>
        <p><strong>Relatório:</strong> Lançamentos da Carteira</p>
        <p><strong>Data de emissão:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p><strong>Competência:</strong> {{ $nomeCompetencia }}</p>
    </div>

    <br>
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
                <tr>
                    <td>Despesa</td>
                    <td>Lançamentos Carro</td>
                    <td>{{ $detalhes['total_despesas_carro'] }}</td>
                    <td>Debitado</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Despesa</td>
                    <td>Lançamentos do Cartão de Crédito</td>
                    <td>{{ $detalhes['total_despesas_cartao_credito'] }}</td>
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
                    <th colspan="3">{{ $detalhes['saldo_inicial'] }}</th>
                </tr>
                <tr>
                    <th colspan="2">(+) Receitas</th>
                    <th colspan="3">{{ $detalhes['total_receitas'] }}</th>
                </tr>
                <tr>
                    <th colspan="2">(-) Despesas</th>
                    <th colspan="3">{{ $detalhes['total_despesas'] }}</th>
                </tr>
                <tr>
                    <th colspan="2">(-) Investimentos</th>
                    <th colspan="3">{{ $detalhes['total_investimentos'] }}</th>
                </tr>
                <tr>
                    <th colspan="2">(=) Saldo Final</th>
                    <th colspan="3">{{ $detalhes['saldo_final'] }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    @else
        <div class="alert alert-warning">
            Nenhum lançamento encontrado para a competência <strong>{{ $nomeCompetencia }}</strong>.
        </div>
    @endif

</body>
</html>
