<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|integer|exists:users,id',
            'image' => 'string'
        ];
    }
    public function messages()
    {
        return [
            'page_id.required' => 'O campo page_id é obrigatório',
            'page_id.integer' => 'O campo page_id deve ser um número inteiro',
            'order.required' => 'O campo order é obrigatório',
            'order.integer' => 'O campo order deve ser um número inteiro',
            'order.max' => 'O campo order não pode ser maior que 3',
            'location.required' => 'O campo location é obrigatório',
            'location.string' => 'O campo location deve ser uma string',
            'location.max' => 'O campo location não pode ter mais de 45 caracteres',
            'deleted.required' => 'O campo deleted é obrigatório',
            'deleted.integer' => 'O campo deleted deve ser um número inteiro',
            'deleted.max' => 'O campo deleted não pode ser maior que 1'
        ];
    }
}


