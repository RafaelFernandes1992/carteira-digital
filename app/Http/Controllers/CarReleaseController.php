<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\CarRelease;
use App\Models\Car;
use App\Http\Requests\CreateCarReleaseRequest;
use App\Http\Requests\StoreCarReleaseRequest;
use App\Http\Requests\EditCarReleaseRequest;
use App\Http\Requests\UpdateCarReleaseRequest;
use App\Http\Requests\DestroyCarReleaseRequest;

class CarReleaseController extends Controller
{

    public function index()
    {
        //
    }

    public function create(CreateCarReleaseRequest $request)
    {
        $data = $request->validated();
        $competenciaId = $data['competenciaId'];
        $search = $data['search'] ?? null;

        $user = Auth::user();

        $query = CarRelease::where('user_id', $user->id)
                ->where('period_id', $competenciaId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('data_despesa', 'like', '%' . $search . '%')
                    ->orWhere('descricao', 'like', '%' . $search . '%')
                    ->orWhere('valor', $search)
                    ->orWhereHas('car', function ($q1) use ($search) {
                        $q1->where('apelido', 'like', '%' . $search . '%');
                    });
            });
        }

        $items = $query->get();

        $carros = Car::where('user_id', $user->id)->get();

        $totalGeral = (float)CarRelease::where('user_id', $user->id)
            ->where('period_id', $competenciaId)
            ->sum('valor');

        $totalCarros = [];
        foreach ($carros as $carro) {
            $total = (float)CarRelease::where('user_id', $user->id)
                ->where('car_id', $carro->id)
                ->where('period_id', $competenciaId)
                ->sum('valor');

            $totalCarros[] = [
                'nome_carro' => $carro->getNome(),
                'total' => Helper::formatToCurrency($total)
            ];
        }

        $items = $items->map(function (CarRelease $item) {
            return [
                'id' => $item->id,
                'data_despesa' => Helper::formatDate($item->data_pagamento_fatura),
                'descricao' => $item->descricao,
                'valor' => Helper::formatToCurrency($item->valor),
                'nome_carro' => $item->car->getNome(),
                'created_at' => Carbon::parse($item->updated_at)->format('d/m/Y H:i:s')
            ];
        });

        return view('car-release.create')->with([
            'items' => $items,
            'competenciaId' => $competenciaId,
            'carros' => $carros,
            'totalCarros' => $totalCarros,
            'totalGeral' => Helper::formatToCurrency($totalGeral),
            'search' => $search
        ]);
    }

    public function store(StoreCarReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = auth()->user()->id;

            CarRelease::create($dados);

            $dados['message'] = 'Lançamento do carro incluído com sucesso!';

            return back()->with($dados);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(EditCarReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            
            $carReleaseItens = CarRelease::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();
            
            return view('car-release.edit')
                ->with([
                    'id' => $carReleaseItens->id,
                    'competenciaId' => $carReleaseItens->period_id,
                    'carId' => $carReleaseItens->car_id,
                    'descricao' => $carReleaseItens->descricao,
                    'valor' => $carReleaseItens->valor,
                    'data_despesa' => $carReleaseItens->data_despesa
                ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(UpdateCarReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $carReleaseItens = CarRelease::where('user_id', Auth::user()->id)
                ->where('id', $dados['id'])->firstOrFail();

            $carReleaseItens->update($dados);

            $dados['message'] = 'Lançamento do carro atualizado com sucesso!';
            return redirect()->route('competencia.carro.lancamento.create', $carReleaseItens->period_id)->with($dados);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(DestroyCarReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $model = CarRelease::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();
            $model->delete();
            return back()->with(['message' => 'Lançamento do carro excluído com sucesso!']);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
