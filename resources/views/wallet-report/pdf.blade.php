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
                    <tr
                        @if ($item['situacao'] === 'Não Debitado')
                            style="background-color: #fff3cd;"
                        @endif
                    >
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
                    <th colspan="5" class="text-start fw-bold">Totalizadores</th>
                </tr>
                <tr>
                    <td colspan="2" class="text-start">
                        {{ $detalhes['saldo_inicial'] >= 0 ? '(+)' : '(-)' }} Saldo Inicial
                    </td>
                    <td colspan="3" class="text-start">
                        R$ {{ $detalhes['saldo_inicial'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start"> (+) Receitas</td>
                    <td colspan="3" class="text-start">
                        R$ {{ $detalhes['total_receitas'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start"> (-) Despesas</td>
                    <td colspan="3" class="text-start">
                        R$ {{ $detalhes['total_despesas'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start"> (-) Investimentos</td>
                    <td colspan="3" class="text-start">
                        R$ {{ $detalhes['total_investimentos'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start"> (=) Saldo Final</td>
                    <td colspan="3" class="text-start fw-bold">
                        R$ {{ $detalhes['saldo_final'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start">(-) Despesas não debitadas</td>
                    <td colspan="3" class="text-start fw-bold">
                        R$ {{ $detalhes['total_despesas_nao_debitadas'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start">(-) Investimentos não debitados</td>
                    <td colspan="3" class="text-start fw-bold">
                        R$ {{ $detalhes['total_investimentos_nao_debitados'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2"class="text-start" >(=) Saldo Final Previsto</td>
                    <td colspan="3" class="text-start fw-bold">
                        R$ {{ $detalhes['saldo_final_previsto'] }}
                    </td>
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
