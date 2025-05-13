@props([
    'items' => [], 
    'totalGeral'
])

<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
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