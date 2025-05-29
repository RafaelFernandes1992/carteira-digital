<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\DestroyUser;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        $users = $users->map(function ($user) {
            
            return [
                'id' => $user->id,
                'nome' => $user->nome,
                'email' => $user->email,
                'created_at' => Carbon::parse($user->updated_at)->format('d/m/Y H:i:s'),
            ];
        });
        return view('users.index')->with(['items' => $users]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['password'] = bcrypt($dados['password']);
    
            User::create($dados);
    
            return redirect()->route('login.index')->with('message', 'Usuário cadastrado com sucesso');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request)
    {
        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $dados = $request->validated();

            // Se informou nova senha, atualiza
            if (!empty($dados['password'])) {
                $dados['password'] = bcrypt($dados['password']);
            } else {
                unset($dados['password']); // Não atualiza senha se não foi informada
            }

            $user->update($dados);

            return back()->with('message', 'Dados atualizados com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy(DestroyUser $request)
    {
        try {
            $dados = $request->validated();
            $model = User::where('id', $dados['id'])->firstOrFail();

            $existe = $model->periodReleases()->exists();
            if ($existe) {
                return back()->withErrors(['error' => 'Não é possível excluir usuário com lançamentos no sistema!']);
            }

            $model->delete();
            return back()->with(['message' => 'Usuário excluído com sucesso!']);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}