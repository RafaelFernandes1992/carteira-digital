@props([
    'items' => []
])
<br>
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
                <td>{{ $item['type_release']['tipo'] }}</td>
                <td>{{ $item['type_release']['descricao'] }}</td>
                <td>{{ $item['valor_total'] }}</td>
                <td>{{ $item['observacao'] }}</td>
                <td>{{ $item['situacao'] }}</td>
                <td>{{ $item['data_debito_credito'] }}</td>
                <td>
                    <div class="d-flex justify-content-center gap-2">
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
        @if(count($items) === 0)
            <tr>
                <td colspan="7">Nenhum registro encontrado.</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>