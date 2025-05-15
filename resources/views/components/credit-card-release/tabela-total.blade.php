@props([
    'items' => [], 
    'totalGeral'
])

<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Totalizador por Cartão de Crédito</th>
                <th>Valor</th>
                <th>Informar pagamento da fatura</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td style="vertical-align: middle;">{{ $item['nome_cartao'] }}</td>
                <td style="vertical-align: middle;">{{ $item['total'] }}</td>
                <td style="vertical-align: middle;">
                    <a class="btn btn-light"
                    href="{{ route('cartao-credito.pagamento-fatura', ['competenciaId' => $item['competenciaId'], 'creditCardId' => $item['creditCardId']]) }}">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        <tfoot>
            <tr>
                <th style="vertical-align: middle;">Soma</th>
                <th style="vertical-align: middle;">{{ $totalGeral }}</th>
                <th style="vertical-align: middle;"></th>
            </tr>
        </tfoot>
        


        @if(count($items) === 0)
            <tr>
                <td colspan="3">Nenhum registro encontrado.</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>