<?php

namespace App\Http\Controllers;

use App\Models\Posting;
use App\Http\Requests\StorePostingRequest;
use App\Http\Requests\UpdatePostingRequest;
use Auth;
use Carbon\Carbon;

class PostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //eager loading
            $data = Posting::with(['user'])->get();
//            $data = Posting::withTrashed()->get();

            $success = count($data) > 0;
            $message = $success ? 'Registros encontrados' : 'Nenhum registro encontrado';

            return response()->json([
                'message' => $message,
                'data' => $data
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
        return view('posting.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostingRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = Auth::user()->id;
            $entityCreated = Posting::create($dados);

            return response()->json([
                'message' => 'Lançamento criado com sucesso!',
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
            $user = Posting::find($id);
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
    public function edit(Posting $posting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostingRequest $request, int $id)
    {
        try {
            $dados = $request->validated();
            Posting::find($id)->update($dados);

            $entityUpdated = Posting::findOrFail($id);

            return response()->json([
                'message' => 'Posting atualizado com sucesso!',
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
    public function destroy(int $id)
    {
        try {
            $model = Posting::find($id);
            if (!$model) {
                return response()->json([
                    'message' => 'Lancamento não foi encontrado!',
                    'data' => null
                ], 404);
            }
            $model->delete();

            return response()->json([
                'message' => 'Lancamento foi excluído com sucesso!',
                'data' => null
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
