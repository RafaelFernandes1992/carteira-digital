@props([
    'competenciaId',
    'cartoes'
])

<br>
<form action="{{ route('competencia.cartao-credito.lancamento.store', $competenciaId) }}" method="POST"
      class="row g-3 align-items-end">
    @csrf
    <div class="col-md-2">
        <label for="credit_card_id" class="form-label">Cartão Crédito
            <span class="text-danger">*</span>
        </label>
        <select class="form-select" aria-label="Default select example" id="credit_card_id" name="credit_card_id" required>
            <option selected value="">Selecione</option>
            @foreach($cartoes as $cartao)
                <option value="{{ $cartao->id }}">{{ $cartao->getNome() }}</option>
            @endforeach
        </select>
    </div>

    <!-- <div class="col-md-4">
        <label for="data_pagamento_fatura" class="form-label">Pago em</label>
        <input class="form-control" type="date" name="data_pagamento_fatura" id="data_pagamento_fatura">
    </div> -->

    <div class="col-md-5">
        <label for="descricao" class="form-label">Descrição
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="text" name="descricao" id="descricao" placeholder="Descreva a compra">
    </div>
    <div class="col-md-2">
        <label for="valor" class="form-label">Valor
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="number" step="0.01" name="valor" id="valor">
    </div>
    <div class="col-md-1">
        <label for="quantidade_parcelas" class="form-label">Nº Parcelas
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="number" min="1" max="18" name="quantidade_parcelas" id="quantidade_parcelas" value="1">
    </div>

    <div class="col-md-2">
        <label for="data_compra" class="form-label">Data da Compra
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="date" name="data_compra" id="data_compra" value="{{ date('Y-m-d') }}">
    </div>


    <!-- <div class="col-md-4">
        <label for="valor_pago_fatura" class="form-label">Valor Pago da Fatura</label>
        <input class="form-control" type="number" step="0.01" name="valor_pago_fatura" id="valor_pago_fatura">
    </div> -->

    <div class="col-md-12">
        <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Salvar</button>
    </div>

</form>
