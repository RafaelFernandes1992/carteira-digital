@extends('layouts.app')


@section('content')
    
<h4>Cadastra Tipo de Lançamento</h4>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
    <a class="btn btn-secondary" href="{{ route('tipo-lancamento.index') }}">    
        <i class="bi bi-arrow-left"></i> Voltar 
    </a>
</div>

<form action="{{ route('tipo-lancamento.store') }}" method="POST" class="row g-3">
    @csrf
    <div class="col-md-2">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-select" aria-label="Default select example" id="tipo" name="tipo" required>
            <option selected>Selecione...</option>
            <option value="receita">Receita</option>
            <option value="despesa">Despesa</option>
            <option value="investimento">Investimento</option>
        </select>
    </div>

    <div class="col-md-4">
        <label for="descricao" class="form-label">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" required>
    </div>

    <div class="col-md-2">
        <label for="rotineira" class="form-label">Rotineiro</label>
        <select class="form-select" aria-label="Default select example" id="rotineira" name="rotineira" required>
            <option selected>Selecione...</option>
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
    </div>

    <div class="col-md-2" id="div-isenta">
        <label for="isenta" class="form-label">Isenta</label>
        <select class="form-select" aria-label="Default select example" id="isenta" name="isenta">
            <option selected value ="" >Selecione...</option>
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
    </div>

    <div class="col-md-2" id="div-dedutivel">
        <label for="dedutivel" class="form-label">Dedutível</label>
        <select class="form-select" aria-label="Default select example" id="dedutivel" name="dedutivel">
            <option selected value ="" >Selecione...</option>
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
    </div>

    <div class="col-md-12">
        <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Salvar</button>
    </div>

</form>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoSelect = document.getElementById('tipo');
        const divDedutivel = document.getElementById('div-dedutivel');
        const divIsenta = document.getElementById('div-isenta');

        console.log('Script carregado'); // teste se o script está rodando

        function verificarTipo() {
            const tipo = tipoSelect.value;
            console.log('Tipo selecionado:', tipo); // debug para ver o valor selecionado

            if (tipo === 'receita') {
                divDedutivel.style.display = 'none';
                divIsenta.style.display = 'block';
                    // Força dedutivel a 0 para evitar null no envio
                    document.getElementById('dedutivel').value = "0";
            } else if (tipo === 'despesa' || tipo === 'investimento') {
                divDedutivel.style.display = 'block';
                divIsenta.style.display = 'none';
                    // Força dedutivel a 0 para evitar null no envio
                    document.getElementById('isenta').value = "0";
            } else {
                divDedutivel.style.display = 'block';
                divIsenta.style.display = 'block';
            }
        }

        tipoSelect.addEventListener('change', verificarTipo);

        verificarTipo();
    });
</script>
