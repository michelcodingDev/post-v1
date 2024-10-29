<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Database\QueryException;
use App\Http\Requests\PostsRequest;

class PostsController extends Controller
{
    /**
     * @group Posts
     *
     * Listar todos os posts
     *
     * Este endpoint retorna uma lista de todos os posts não deletados.
     *
     * @response 200 {
     *   "id": 1,
     *   "title": "Meu primeiro post",
     *   "content": "Este é o conteúdo do post.",
     *   "author_id": 1,
     *   "created_at": "2023-08-30T19:20:02.000000Z",
     *   "updated_at": "2023-08-30T19:20:02.000000Z"
     * }
     * @response 404 {
     *   "error": "Nenhum post foi encontrada."
     * }
     * @authenticated
     * @header Authorization Bearer 1|LinnYgzxQm7zEQjdKg84GClWcTHfSrd0pGN9LLdWac9515e5
     */
    public function index(Post $posts)
    {
        try {
            $posts = $posts->where('deleted', false)->get();
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Nenhum post foi encontrado.'], 404);
        }
    }

/**
     * @group Posts
     *
     * Criar um novo post
     *
     * Este endpoint permite criar um novo post.
     *
     * @bodyParam title string required O título do post. Exemplo: Meu novo post
     * @bodyParam content string required O conteúdo do post.
     * @bodyParam author_id integer required O ID do autor. Exemplo: 1
     * @bodyParam image string O link da imagem. Exemplo: http://exemplo.com/imagem.png
     *
     * @response 201 {
     *   "message": "Post criado com sucesso.",
     *   "data": {
     *     "id": 1,
     *     "title": "Meu novo post",
     *     "content": "Este é o conteúdo do post.",
     *     "author_id": 1,
     *     "created_at": "2023-08-30T19:20:02.000000Z",
     *     "updated_at": "2023-08-30T19:20:02.000000Z"
     *   }
     * }
     * @response 422 {
     *   "error": "Erro de validação",
     *   "messages": {
     *     "title": ["O campo título é obrigatório."],
     *     "content": ["O campo conteúdo é obrigatório."]
     *   }
     * }
     * @response 500 {
     *   "error": "Erro no banco de dados."
     * }
     * @authenticated
     * @header Authorization Bearer 1|LinnYgzxQm7zEQjdKg84GClWcTHfSrd0pGN9LLdWac9515e5
     */
    public function create(PostsRequest $request)
    {
        
        try {
            $validatedData = $request->validated();

            $post = Post::create($validatedData);

            return response()->json([
                'message' => 'Post criado com sucesso.',
                'data' => $post
            ], 201);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Erro de validação', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro: ' . $e->getMessage()], 500);
        }
    }
 /**
     * @group Posts
     *
     * Exibir um post
     *
     * Este endpoint retorna os detalhes de um post específico.
     *
     * @urlParam id integer required O ID do post. Exemplo: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "title": "Meu primeiro post",
     *   "content": "Este é o conteúdo do post.",
     *   "author_id": 1,
     *   "created_at": "2023-08-30T19:20:02.000000Z",
     *   "updated_at": "2023-08-30T19:20:02.000000Z"
     * }
     * @response 404 {
     *   "error": "Post não encontrado."
     * }
     * @response 500 {
     *   "error": "Erro no banco de dados."
     * }
     * @authenticated
     * @header Authorization Bearer 1|LinnYgzxQm7zEQjdKg84GClWcTHfSrd0pGN9LLdWac9515e5
     */
    public function show($id)
    {
       
     try {

        $post = Post::findOrFail($id);

        if(!$post){
            return response()->json(['error' => 'Post não encontrado.'], 404);
        }

          return response()->json($post);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);

        }  catch (\Exception $e) {
            return response()->json(['error' => 'Post não encontrado'], 500);
        }
    }

/**
     * @group Posts
     *
     * Atualizar um post
     *
     * Este endpoint permite atualizar um post existente.
     *
     * @urlParam id integer required O ID do post. Exemplo: 1
     * @bodyParam title string O novo título do post. Exemplo: Título atualizado
     * @bodyParam content string O novo conteúdo do post.
     * @bodyParam author_id integer O ID atualizado do autor.
     *
     * @response 200 {
     *   "message": "Post atualizado com sucesso.",
     *   "data": {
     *     "id": 1,
     *     "title": "Título atualizado",
     *     "content": "Conteúdo atualizado",
     *     "author_id": 1,
     *     "created_at": "2023-08-30T19:20:02.000000Z",
     *     "updated_at": "2023-08-30T19:40:02.000000Z"
     *   }
     * }
     * @response 404 {
     *   "error": "Post não encontrado."
     * }
     * @response 422 {
     *   "error": "Erro de validação",
     *   "messages": {
     *     "title": ["O campo título é obrigatório."],
     *     "content": ["O campo conteúdo é obrigatório."]
     *   } 
     * }
     * @response 500 {
     *   "error": "Erro no banco de dados."
     * }
     * @authenticated
     * @header Authorization Bearer 1|LinnYgzxQm7zEQjdKg84GClWcTHfSrd0pGN9LLdWac9515e5
     */
    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->deleted) {
                return response()->json(['error' => 'Post não encontrado.'], 404);
            }

            $validatedData = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'content' => 'sometimes|required|string',
                'author_id' => 'sometimes|required|integer|exists:users,id'               
            ]);

            $post->update($validatedData);

            return response()->json([
                'message' => 'Post atualizado com sucesso.',
                'data' => $post
            ]);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Erro de validação', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro: ' . $e->getMessage()], 500);
        }
    }
    
 /**
     * @group Posts
     *
     * Excluir um post
     *
     * Este endpoint marca um post como excluído.
     *
     * @urlParam id integer required O ID do post. Exemplo: 1
     *
     * @response 200 {
     *   "message": "Post excluído com sucesso."
     * }
     * @response 404 {
     *   "error": "Post não encontrado."
     * }
     * @response 500 {
     *   "error": "Erro no banco de dados."
     * }
     * @authenticated
     * @header Authorization Bearer 1|LinnYgzxQm7zEQjdKg84GClWcTHfSrd0pGN9LLdWac9515e5
     */
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            $post->update(['deleted' => 1]);

            return response()->json(['message' => 'Post excluído com sucesso.']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro: ' . $e->getMessage()], 500);
        }
    }
}
