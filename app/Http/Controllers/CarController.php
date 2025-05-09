<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Requests\DestroyCarRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CarController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $itensCar = Car::where('user_id', $user->id)->get();
        $itensCar = $itensCar->map(function ($item) {
            
            return [
                'id' => $item->id,
                'renavam' => $item->renavam,
                'apelido' => $item->apelido,
                'placa' => $item->placa,
                'marca' => $item->marca,
                'modelo' => $item->modelo,
                'data_aquisicao' => Carbon::parse($item->data_aquisicao)->format('d/m/Y'),
                'created_at' => Carbon::parse($item->updated_at)->format('d/m/Y H:i:s'),
            ];
        });
        return view('car.index')->with(['itensCar' => $itensCar]);
    }

    public function create()
    {
        return view('car.create');
    }

    public function store(StoreCarRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = auth()->user()->id;
            Car::create($dados);

            $dados['message'] = 'Carro incluído com sucesso!';
            return redirect()->route('carro.index')->with('message', 'Carro incluído com sucesso!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Car $car)
    {
        //
    }

    public function edit(Car $car)
    {
        //
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        //
    }

    public function destroy(DestroyCarRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $model = Car::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();
            
            // $existePeriodRelease = $model->periodReleases()->exists();
            // if ($existePeriodRelease) {
            //     return back()->withErrors(['error' => 'Não é possível excluir um tipo de lançamento que já está sendo utilizado!']);
            // }  

            $model->delete();
            return back()->with(['message' => 'Carro excluído com sucesso!']);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}