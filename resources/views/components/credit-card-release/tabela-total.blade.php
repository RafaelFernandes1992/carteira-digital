@props([
    'items' => [], 
    'totalGeral'
])

<div class="table-responsive small tabela-total-container">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th scope="col">Total geral das faturas</th>
            <th scope="col">{{ $totalGeral }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>Total da fatura do cartão {{ $item['nome_cartao'] }}</td>
                <td>{{ $item['total'] }}</td>
            </tr>
        @endforeach


        @if(count($items) === 0)
            <tr>
                <td colspan="9">Nenhum registro encontrado.</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>