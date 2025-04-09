@props([
    'items' => []
])
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th scope="col">Tipo</th>
            <th scope="col">Descrição</th>
            <th scope="col">Valor</th>
            <th scope="col">Observação</th>
            <th scope="col">Situação</th>
            <th scope="col">Data</th>
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>Algum tipo</td>
                <td>Alguma descrição</td>
                <td>{{ $item['valor_total'] }}</td>
                <td>{{ $item['observacao'] }}</td>
                <td>{{ $item['situacao'] }}</td>
                <td>{{ $item['data_debito_credito'] }}</td>
                <td>

                    <button class="btn btn-warning">
                        Alterar
                    </button>
                    <form action="{{ route('competencia.lancamento.destroy', $item['id']) }}" method="post">
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">
                            Excluir
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        @if(count($items) === 0)
            <tr>
                <td colspan="7">Nenhum registro encontrado.</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>