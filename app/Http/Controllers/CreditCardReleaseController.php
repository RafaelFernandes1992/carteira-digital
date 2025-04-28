<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\CreditCard;
use App\Models\CreditCardRelease;
use App\Http\Requests\StoreCreditCardReleaseRequest;
use App\Http\Requests\UpdateCreditCardReleaseRequest;
use Illuminate\Support\Facades\Auth;

class CreditCardReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $competenciaId)
    {
        $user = Auth::user();
        $items = CreditCardRelease::where('user_id', $user->id)->get();
        $cartoes = CreditCard::where('user_id', $user->id)->get();

        $items = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'data_compra' => Helper::formatDate($item->data_compra),
                'data_pagamento_fatura' => Helper::formatDate($item->data_pagamento_fatura),
                'descricao' => $item->descricao,
                'quantidade_parcelas' => $item->quantidade_parcelas,
                'valor' => Helper::formatToCurrency($item->valor),
                'valor_pago_fatura' => Helper::formatToCurrency($item->valor_pago_fatura),
                'valor_parcela' => Helper::formatToCurrency($item->valor_parcela),
            ];
        });

        return view('credit-card-release.create')->with([
            'items' => $items,
            'competenciaId' => $competenciaId,
            'cartoes' => $cartoes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCreditCardReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = auth()->user()->id;
            $dados['valor_parcela'] = $dados['valor'] / $dados['quantidade_parcelas'];

            CreditCardRelease::create($dados);

            $dados['message'] = 'Lançamento do cartão de crédito incluído com sucesso!';

            return back()->with($dados);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CreditCardRelease $creditCardRelease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CreditCardRelease $creditCardRelease)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCreditCardReleaseRequest $request, CreditCardRelease $creditCardRelease)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditCardRelease $creditCardRelease)
    {
        //
    }
}
