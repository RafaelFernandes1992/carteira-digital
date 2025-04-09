@props([
    'competenciaId'
])

<form action="{{ route('competencia.lancamento.store', $competenciaId) }}" method="POST"
      class="row g-3 align-items-end">

    <input type="hidden" name="period_id" value="1">

    <div class="col-md-2">
        <label for="tipoOperacao" class="form-label">Tipo</label>
        <select
                {{--                onchange="preencherOpcoesSelect(this)" --}}
                class="form-select" aria-label="Default select example" id="tipoOperacao" name="tipoOperacao"
                {{--                    required--}}
        >
            <option selected value="despesa">Despesa</option>
            <option value="receita">Receita</option>
            <option value="investimento">Investimento</option>
        </select>
    </div>

    <div class="col-md-4">
        <label for="type_release_id" class="form-label">Descrição</label>
        <select class="form-select" aria-label="Default select example" id="type_release_id" name="type_release_id"
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

<script>
    let tiposLancamentos = null;
    document.addEventListener('DOMContentLoaded', async function () {
        await getTiposLancamento();
        lidarComAlteracaoNoSelect();
        carregaOpcoesAoInicarPagina();
    });

    function carregaOpcoesAoInicarPagina() {
        const descricoes = getDescricoesPorTipo("despesa");
        criaOpcoesNoSelectDescricao(descricoes);
    }

    function lidarComAlteracaoNoSelect() {
        const select = document.getElementById('tipoOperacao');
        select.addEventListener('change', (event) => {
            const descricoes = getDescricoesPorTipo(event.target.value);
            criaOpcoesNoSelectDescricao(descricoes);
        });
    }

    function criaOpcoesNoSelectDescricao(valores) {
        const inputDescricao = document.getElementById('type_release_id');

        inputDescricao.innerHTML = '';
        valores.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.descricao;
            inputDescricao.appendChild(option);
        });

    }

    function getDescricoesPorTipo(tipo) {
        return tiposLancamentos.filter(item => item.tipo === tipo);
    }

    async function getTiposLancamento() {
        try {
            const response = await axios.get('/tipo-lancamento');
            tiposLancamentos = response.data.data

        } catch (error) {
            console.error(error)
        }
    }
</script>
