<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{

    public function  auth(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
             return response($response, 201);
        
    }
    
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

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json(['token' => $token,'user' => $user,], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

}