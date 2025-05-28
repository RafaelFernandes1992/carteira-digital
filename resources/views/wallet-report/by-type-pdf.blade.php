<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório Anual por Tipo</title>
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
        <p><strong>Relatório:</strong> Anual por Tipo de Lançamento</p>
        <p><strong>Data de emissão:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p><strong>Ano:</strong>  {{ $ano }}</p>
        <p><strong>Tipo:</strong> {{ $tipo }}</p>
        @if($descricaoId)
            <p><strong>Descrição:</strong> {{ $descricoes->where('id', $descricaoId)->first()->descricao ?? '' }}</p>
        @endif
    </div>
    <br>
    
    <table>
        <thead>
            <tr>
                <th>Competência</th>
                <th>Data</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Situação</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item['competencia'] }}</td>
                    <td>{{ $item['data_debito_credito'] }}</td>
                    <td>{{ $item['descricao'] }}</td>
                    <td>R$ {{ $item['valor_total'] }}</td>
                    <td>{{ $item['situacao'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Nenhum lançamento encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>