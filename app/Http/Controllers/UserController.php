<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\LoginV2UserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // php artisan serve
    // npm run dev
    // acessar url http://localhost:8000

    public function create()
    {
        return view('users.create');
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        try {
            $dados = $request->validated();

            if (!Auth::attempt($dados)) {
                throw new \Exception('Email ou senha inválidos');
            }

            return response()->json([
                'message' => 'Usuário logado com sucesso!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function loginV2(LoginV2UserRequest $request)
    {
        $dados = $request->validated();

        if (!Auth::attempt($dados)) {
            return back()
                ->withErrors(['general' => 'Credenciais inválidas.'])
                ->withInput();
        }

        return redirect()->route('index.home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('index.login');
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $dados = $request->validated();
            $entityCreated = User::create($dados);

            return response()->json([
                'message' => 'Usuário criado com sucesso!',
                'data' => $entityCreated
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        try {
            $dados = $request->validated();
            User::find($id)->update($dados);

            $entityUpdated = User::findOrFail($id);

            return response()->json([
                'message' => 'Usuário atualizado com sucesso!',
                'data' => $entityUpdated
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Recurso não encontrado',
                'data' => null
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            User::find($id)->delete();

            return response()->json([
                'message' => 'Usuário foi excluído com sucesso!',
                'data' => null
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $user = User::find($id);
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

    public function index(): JsonResponse
    {
        try {
            $data = User::withCount(['typeReleases'])->get();

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
}
