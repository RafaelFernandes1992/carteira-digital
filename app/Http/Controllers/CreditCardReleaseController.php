<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CreateCreditCardReleaseRequest;
use App\Http\Requests\DestroyCreditCardReleaseRequest;
use App\Http\Requests\EditCreditCardReleaseRequest;
use App\Models\CreditCard;
use App\Models\CreditCardRelease;
use App\Http\Requests\StoreCreditCardReleaseRequest;
use App\Http\Requests\UpdateCreditCardReleaseRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CreditCardReleaseController extends Controller
{

    public function index()
    {
        //
    }

    public function create(CreateCreditCardReleaseRequest $request)
    {
        $data = $request->validated();
        $competenciaId = $data['competenciaId'];
        $search = $data['search'] ?? null;

        $user = Auth::user();

        $query = CreditCardRelease::where('user_id', $user->id)
                ->where('period_id', $competenciaId);

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
            ->where('period_id', $competenciaId)
            ->sum('valor_parcela');

        $totalCartoes = [];
        foreach ($cartoes as $cartao) {
            $total = (float)CreditCardRelease::where('user_id', $user->id)
                ->where('credit_card_id', $cartao->id)
                ->where('period_id', $competenciaId)
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
                'nome_cartao' => $item->creditCard->getNome(),
                'created_at' => Carbon::parse($item->updated_at)->format('d/m/Y H:i:s')
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

    public function edit(EditCreditCardReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            
            $creditCardReleaseItens = CreditCardRelease::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();
            
            return view('credit-card-release.edit')
                ->with([
                    'id' => $creditCardReleaseItens->id,
                    'competenciaId' => $creditCardReleaseItens->period_id,
                    'creditCardId' => $creditCardReleaseItens->credit_card_id,
                    'descricao' => $creditCardReleaseItens->descricao,
                    'valor' => $creditCardReleaseItens->valor,
                    'quantidade_parcelas' => $creditCardReleaseItens->quantidade_parcelas,
                    'data_compra' => $creditCardReleaseItens->data_compra
                ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(UpdateCreditCardReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['valor_parcela'] = $dados['valor'] / $dados['quantidade_parcelas'];
            $creditCardReleaseItens = CreditCardRelease::where('user_id', Auth::user()->id)
                ->where('id', $dados['id'])->firstOrFail();

            $creditCardReleaseItens->update($dados);

            $dados['message'] = 'Lançamento do cartão de crédito atualizado com sucesso!';
            return redirect()->route('competencia.cartao-credito.lancamento.create', $creditCardReleaseItens->period_id)->with($dados);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(DestroyCreditCardReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $model = CreditCardRelease::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();
            $model->delete();
            return back()->with(['message' => 'Lançamento do Cartão de Crédito excluído com sucesso!']);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
