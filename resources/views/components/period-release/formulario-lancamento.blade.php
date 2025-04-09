@props([
    'competenciaId'
])

<form action="{{ route('competencia.lancamento.store', $competenciaId) }}" method="POST" class="row g-3 align-items-end">

    <input type="hidden" name="period_id" value="1">

    <div class="col-md-2">
        <label for="tipoOperacao" class="form-label">Tipo</label>
        <select
                {{--                onchange="preencherOpcoesSelect(this)" --}}
                class="form-select" aria-label="Default select example" id="tipoOperacao" name="tipoOperacao"
                {{--                    required--}}
        >
            <option selected>Selecione...</option>
            <option value="receita">Receita</option>
            <option value="despesa">Despesa</option>
            <option value="investimento">Investimento</option>
        </select>
    </div>

    <div class="col-md-4">
        <label for="inputidcodigo" class="form-label">Descrição</label>
        <select class="form-select" aria-label="Default select example" id="inputidcodigo" name="inputidcodigo"
                {{--                    required--}}
        >
            <!-- usando função JS preencherOpcoesSelect() para carregar a lista -->
        </select>
    </div>

    <div class="col-md-2">
        <label for="valor_total" class="form-label">Valor</label>
        <input type="text" class="form-control" id="valor_total" name="valor_total" placeholder="0,00" required>
    </div>
    <div class="col-md-2">
        <label for="situacao" class="form-label">Situação</label>
        <select class="form-select" aria-label="Default select example" id="situacao" name="situacao"
                required>
            <option selected>Selecione...</option>
            <option value="creditado">Creditado</option>
            <option value="debitado">Debitado</option>
            <option value="nao_debitado">Não debitado</option>
        </select>
    </div>

    <div class="col-md-2">
        <label for="data_debito_credito" class="form-label">Data</label>
        <input type="date" class="form-control" id="data_debito_credito" name="data_debito_credito" required>
    </div>
    <div class="col-md-11">
        <label for="observacao" class="form-label">Observação</label>
        <input type="text" class="form-control" id="observacao" name="observacao">
    </div>

    <div class="col-md-1">
        <button type="submit" class="btn btn-primary" name="gravar" id="gravar">Gravar</button>
    </div>
</form>
