<?php

namespace App\Http\Controllers;

use App\Models\CreditCard;
use App\Http\Requests\StoreCreditCardRequest;
use App\Http\Requests\UpdateCreditCardRequest;
use App\Http\Requests\DestroyCreditCardRequest;
use App\Http\Requests\EditCreditCardRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CreditCardController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $itensCreditCard = CreditCard::where('user_id', $user->id)->get();
        $itensCreditCard = $itensCreditCard->map(function ($item) {
            
            return [
                'id' => $item->id,
                'numero_cartao' => $item->numero_cartao,
                'apelido' => $item->apelido,
                'valor_limite' => $item->valor_limite,
                'dia_vencimento_fatura' => $item->dia_vencimento_fatura,
                'dia_fechamento_fatura' => $item->dia_fechamento_fatura, 
                'created_at' => Carbon::parse($item->updated_at)->format('d/m/Y H:i:s'),
            ];
        });
        return view('credit-card.index')->with(['itensCreditCard' => $itensCreditCard]);
    }

    public function create()
    {
        return view('credit-card.create');
    }

    public function store(StoreCreditCardRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = auth()->user()->id;
            CreditCard::create($dados);

            $dados['message'] = 'Cartão de Crédito incluído com sucesso!';
            return redirect()->route('cartao-credito.index')->with('message', 'Cartão de Crédito incluído com sucesso!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(EditCreditCardRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $creditCard = CreditCard::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();

            return view('credit-card.edit')
                ->with([
                    'id' => $creditCard->id,
                    'numero_cartao' => $creditCard->numero_cartao,
                    'apelido' => $creditCard->apelido,
                    'valor_limite' => $creditCard->valor_limite,
                    'dia_vencimento_fatura' => $creditCard->dia_vencimento_fatura,
                    'dia_fechamento_fatura' => $creditCard->dia_fechamento_fatura,
                ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(UpdateCreditCardRequest $request)
    {
        try {
            $dados = $request->validated();
            $creditCard = CreditCard::where('user_id', Auth::user()->id)
                ->where('id', $dados['id'])->firstOrFail();
            $creditCard->update($dados);

            $dados['message'] = 'Cartão de Crédito atualizado com sucesso!';
            return redirect()->route('cartao-credito.index')->with($dados);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(DestroyCreditCardRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $model = CreditCard::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();
            
            // $existePeriodRelease = $model->periodReleases()->exists();
            // if ($existePeriodRelease) {
            //     return back()->withErrors(['error' => 'Não é possível excluir um tipo de lançamento que já está sendo utilizado!']);
            // }  

            $model->delete();
            return back()->with(['message' => 'Cartão de Crédito excluído com sucesso!']);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}