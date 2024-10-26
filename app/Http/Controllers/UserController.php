<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Autentica o utilizador e gera um token de autenticação.
     *
     * @group Autenticação
     * @bodyParam email string required O email do utilizador. Example: johndoe@example.com
     * @bodyParam password string required A senha do utilizador. Example: password123
     * @response 201 {
     *   "user": { "id": 1, "name": "John Doe", "email": "johndoe@example.com" },
     *   "token": "eyJ0eXAiOiJKV1..."
     * }
     */
    public function auth(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['Estas credenciais não correspondem aos nossos registos.']
            ], 404);
        }
        
        $token = $user->createToken('my-app-token')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response($response, 201);
    }
    
    /**
     * Lista todos os utilizadores.
     *
     * @group Utilizadores
     * @response 200 [{
     *   "id": 1,
     *   "name": "John Doe",
     *   "email": "johndoe@example.com"
     * }]
     */
    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Erro no banco de dados: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibe um utilizador específico.
     *
     * @group Utilizadores
     * @urlParam id integer required O ID do utilizador. Example: 1
     * @response 200 {
     *   "id": 1,
     *   "name": "John Doe",
     *   "email": "johndoe@example.com"
     * }
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Erro no banco de dados: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualiza um utilizador.
     *
     * @group Utilizadores
     * @urlParam id integer required O ID do utilizador. Example: 1
     * @bodyParam name string required O nome do utilizador. Example: John Doe
     * @bodyParam email string required O email do utilizador. Example: johndoe@example.com
     * @bodyParam password string required A nova senha do utilizador. Example: password123
     * @response 201 {
     *   "message": "Usuário atualizado com sucesso.",
     *   "data": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "johndoe@example.com"
     *   }
     * }
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::findOrFail($id);
            $user->update($validatedData);
            return response()->json([
                'message' => 'Usuário atualizado com sucesso.',
                'data' => $user
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erro de validação',
                'messages' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Erro no banco de dados: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exclui um utilizador.
     *
     * @group Utilizadores
     * @urlParam id integer required O ID do utilizador. Example: 1
     * @response 200 {
     *   "message": "Usuário deletado com sucesso"
     * }
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'Usuário deletado com sucesso']);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Erro no banco de dados: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cria um novo utilizador.
     *
     * @group Utilizadores
     * @bodyParam name string required O nome do utilizador. Example: John Doe
     * @bodyParam email string required O email do utilizador. Example: johndoe@example.com
     * @bodyParam password string required A senha do utilizador. Example: password123
     * @response 201 {
     *   "message": "Usuário criado com sucesso.",
     *   "data": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "johndoe@example.com"
     *   }
     * }
     */
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create($validatedData);

            return response()->json([
                'message' => 'Usuário criado com sucesso.',
                'data' => $user
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erro de validação',
                'messages' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Erro no banco de dados: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Realiza o login do utilizador.
     *
     * @group Autenticação
     * @bodyParam email string required O email do utilizador. Example: johndoe@example.com
     * @bodyParam password string required A senha do utilizador. Example: password123
     * @response 200 {
     *   "token": "eyJ0eXAiOiJKV1...",
     *   "user": { "id": 1, "name": "John Doe", "email": "johndoe@example.com" }
     * }
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
