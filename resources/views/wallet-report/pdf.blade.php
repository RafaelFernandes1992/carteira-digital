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
    </style>
</head>
<body>

    <h4>Relatório - Lançamentos da Carteira - Competência: {{ $nomeCompetencia }}</h4>

    @if(count($items) > 0)
        <table>
            <thead>
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
    @else
        <p>Nenhum lançamento encontrado para a competência {{ $nomeCompetencia }}.</p>
    @endif

</body>
</html>
