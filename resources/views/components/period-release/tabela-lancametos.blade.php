@props([
    'items' => []
])
<br>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Tipo</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Situação</th>
            <th>Data</th>
            <th>Observação</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item['type_release']['tipo'] }}</td>
                <td>{{ $item['type_release']['descricao'] }}</td>
                <td>{{ $item['valor_total'] }}</td>
                <td>{{ $item['situacao'] }}</td>
                <td>{{ $item['data_debito_credito'] }}</td>
                <td>{{ $item['observacao'] }}</td>
                <td>
                    <div class="d-flex gap-2">
                        <a class="btn btn-warning" href="{{ route('lancamento.edit', $item['id']) }}">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('competencia.lancamento.destroy', $item['id']) }}" method="POST">
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
            <tr>
                <td>Despesa</td>
                <td><i class="bi bi-car-front"></i> Lançamentos do Carro</td>
                <td colspan="4">0,00</td>
                <td>
                    <a class="btn btn-light" href="#">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td>Despesa</td>
                <td><i class="bi bi-credit-card-2-back"></i> Lançamentos do Cartão de Crédito</td>
                <td colspan="4">0,00</td>
                <td>
                    <a class="btn btn-light" href="{{ route('competencia.cartao-credito.lancamento.create', $competenciaId) }}">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </td>
            </tr>
        @if(count($items) === 0)
            <!-- <tr>
                <td colspan="7">Nenhum registro encontrado.</td>
            </tr> -->
        @endif
        </tbody>
    </table>
</div>