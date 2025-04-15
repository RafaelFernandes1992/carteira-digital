<?php

namespace App\Http\Controllers;

use App\Models\TypeRelease;
use App\Http\Requests\DestroyTypeReleaseRequest;
use App\Http\Requests\StoreTypeReleaseRequest;
use App\Http\Requests\UpdateTypeReleaseRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TypeReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $user = Auth::user();
        $itens = TypeRelease::where('user_id', $user->id)->get();
        $itens = $itens->map(function ($item) {
            
            return [
                'id' => $item->id,
                'descricao' => $item->descricao,
                'rotineira' => $item->rotineira,
                'dedutivel' => $item->dedutivel,
                'isenta' => $item->isenta,
                'tipo' => $item->tipo,
                'created_at' => Carbon::parse($item->updated_at)->format('d/m/Y H:i:s'),
            ];
        });
        return view('type-release.index')->with(['itens' => $itens]);
    }

    public function getAll()
    {
        try {
            //eager loading
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('type-release.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = Auth::user()->id;
            $entityCreated = TypeRelease::create($dados);

            return response()->json([
                'message' => 'Tipo de lançamento criado com sucesso!',
                'data' => $entityCreated
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeReleaseRequest $request, int $id)
    {
        try {
            $dados = $request->validated();
            TypeRelease::find($id)->update($dados);

            $entityUpdated = TypeRelease::findOrFail($id);

            return response()->json([
                'message' => 'Tipo de lançamento atualizado com sucesso!',
                'data' => $entityUpdated
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(DestroyTypeReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $user = Auth::user();
            $model = TypeRelease::where('user_id', $user->id)
                ->where('id', $dados['id'])->firstOrFail();
            $model->delete();
            return back()->with(['message' => 'Lancamento excluido com sucesso']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    // public function destroy(int $id)
    // {
    //     try {
    //         $model = TypeRelease::find($id);
    //         if (!$model) {
    //             return response()->json([
    //                 'message' => 'Tipo de lançamento não foi encontrado!',
    //                 'data' => null
    //             ], 404);
    //         }
    //         $model->delete();

    //         return response()->json([
    //             'message' => 'Tipo de lançamento foi excluído com sucesso!',
    //             'data' => null
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => $e->getMessage(),
    //             'data' => null
    //         ], 500);
    //     }
    // }


}