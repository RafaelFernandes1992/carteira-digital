@props([
    'items' => [], 
    'totalGeral'
])

<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="4">Totalizador por Cartão de Crédito</th>
                <th>Valor</th>
                <th>Informar pagamento da fatura</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td scope="4">{{ $item['nome_cartao'] }}</td>
                <td>{{ $item['total'] }}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="#">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        <tfoot>
            <tr>
                <th scope="4">Soma</th>
                <th>{{ $totalGeral }}</th>
                <th></th>
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