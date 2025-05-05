<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CreateCreditCardReleaseRequest;
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
    public function create(CreateCreditCardReleaseRequest $request)
    {
        $data = $request->validated();
        $competenciaId = $data['competenciaId'];
        $search = $data['search'] ?? null;


        $user = Auth::user();

        $query = CreditCardRelease::where('user_id', $user->id);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('data_compra', 'like', '%' . $search . '%')
                    ->orWhere('quantidade_parcelas', $search)
                    ->orWhere('descricao', 'like', '%' . $search . '%')
                    ->orWhere('valor_parcela', $search)
                    ->orWhere('valor_pago_fatura', $search)
                    ->orWhere('data_pagamento_fatura', 'like', '%' . $search . '%')
                    ->orWhereHas('creditCard', function ($q1) use ($search) {
                        $q1->where('apelido', 'like', '%' . $search . '%');
                    });
            });
        }

        $items = $query->get();

        $cartoes = CreditCard::where('user_id', $user->id)->get();

        $totalGeral = (float)CreditCardRelease::where('user_id', $user->id)
            ->sum('valor_parcela');


        $totalCartoes = [];
        foreach ($cartoes as $cartao) {

            $total = (float)CreditCardRelease::where('user_id', $user->id)
                ->where('credit_card_id', $cartao->id)
                ->sum('valor_parcela');

            $totalCartoes[] = [
                'nome_cartao' => $cartao->getNome(),
                'total' => Helper::formatToCurrency($total)
            ];
        }

        $items = $items->map(function (CreditCardRelease $item) {
            return [
                'id' => $item->id,
                'data_compra' => Helper::formatDate($item->data_compra),
                'data_pagamento_fatura' => Helper::formatDate($item->data_pagamento_fatura),
                'descricao' => $item->descricao,
                'quantidade_parcelas' => $item->quantidade_parcelas,
                'valor' => Helper::formatToCurrency($item->valor),
                'valor_pago_fatura' => Helper::formatToCurrency($item->valor_pago_fatura),
                'valor_parcela' => Helper::formatToCurrency($item->valor_parcela),
                'nome_cartao' => $item->creditCard->getNome()
            ];
        });

        return view('credit-card-release.create')->with([
            'items' => $items,
            'competenciaId' => $competenciaId,
            'cartoes' => $cartoes,
            'totalCartoes' => $totalCartoes,
            'totalGeral' => Helper::formatToCurrency($totalGeral),
            'search' => $search
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
