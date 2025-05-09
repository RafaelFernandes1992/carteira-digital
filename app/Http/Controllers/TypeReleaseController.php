<?php

namespace App\Http\Controllers;

use App\Models\TypeRelease;
use App\Http\Requests\DestroyTypeReleaseRequest;
use App\Http\Requests\StoreTypeReleaseRequest;
use App\Http\Requests\UpdateTypeReleaseRequest;
use App\Http\Requests\EditTypeReleaseRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TypeReleaseController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $itens = TypeRelease::where('user_id', $user->id)->get();
        $itens = $itens->map(function ($item) {
            
            return [
                'id' => $item->id,
                'tipo' => ucfirst($item->tipo),
                'descricao' => $item->descricao,
                'rotineira' => $item->rotineira ? 'Sim' : 'Não',
                'isenta' => $item->isenta ? 'Sim' : 'Não',
                'dedutivel' => $item->dedutivel ? 'Sim' : 'Não', 
                'created_at' => Carbon::parse($item->updated_at)->format('d/m/Y H:i:s'),
            ];
        });
        return view('type-release.index')->with(['itens' => $itens]);
    }

    public function create()
    {
        return view('type-release.create');
    }

    public function store(StoreTypeReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = auth()->user()->id;
            TypeRelease::create($dados);

            $dados['message'] = 'Tipo de lançamento incluído com sucesso!';
            return redirect()->route('tipo-lancamento.index')->with('message', 'Tipo de lançamento incluído com sucesso!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function edit(EditTypeReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $typeRelease = TypeRelease::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();

            return view('type-release.edit')
                ->with([
                    'id' => $typeRelease->id,
                    'tipo' => $typeRelease->tipo,
                    'descricao' => $typeRelease->descricao,
                    'rotineira' => $typeRelease->rotineira,
                    'dedutivel' => $typeRelease->dedutivel,
                    'isenta' => $typeRelease->isenta,
                ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function update(UpdateTypeReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $typerelease = TypeRelease::where('user_id', Auth::user()->id)
                ->where('id', $dados['id'])->firstOrFail();
            $typerelease->update($dados);

            $dados['message'] = 'Tipo de lançamento atualizado com sucesso!';
            return redirect()->route('tipo-lancamento.index')->with($dados);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(DestroyTypeReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $model = TypeRelease::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();
            
            $existePeriodRelease = $model->periodReleases()->exists();
            if ($existePeriodRelease) {
                return back()->withErrors(['error' => 'Não é possível excluir um tipo de lançamento que já está sendo utilizado!']);
            }  

            $model->delete();
            return back()->with(['message' => 'Tipo de lançamento excluído com sucesso!']);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    //extras - end-point
    public function show(int $id)
    {
        try {
            $user = TypeRelease::find($id);
            $message = $user ? 'Registros encontrados' : 'Nenhum registro encontrado';

            return response()->json([
                'message' => $message,
                'data' => $user ?? []
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getAll()
    {
        try {
            $user = Auth::user();
            $dados = TypeRelease::where('user_id', $user->id)
                ->select(['id', 'tipo', 'descricao'])
                ->get();

            $success = count($dados) > 0;
            $message = $success ? 'Registros encontrados' : 'Nenhum registro encontrado';

            return response()->json([
                'message' => $message,
                'data' => $dados
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

}