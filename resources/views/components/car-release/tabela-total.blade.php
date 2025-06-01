@props([
    'items' => [], 
    'totalGeral'
])
<div class="p-3 bg-light border rounded">
<div class="table-responsive small">
    <table class="table table-sm">
        <thead class="table-light">
            <tr>
                <th>Totalizador por Carro</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td style="vertical-align: middle;">{{ $item['nome_carro'] }}</td>
                <td style="vertical-align: middle;">{{ $item['total'] }}</td>
            </tr>
        @endforeach
        <tfoot>
            <tr>
                <th style="vertical-align: middle;">Soma</th>
                <th style="vertical-align: middle;">{{ $totalGeral }}</th>
            </tr>
        </tfoot>
        


        @if(count($items) === 0)
            <tr>
                <td colspan="2">Nenhum registro encontrado.</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
</div>