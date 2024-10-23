<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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

    public function messages(): array
    {
        return [
            'title.required' => 'O campo título é obrigatório.',
            'content.required' => 'O campo conteúdo é obrigatório.',
            'author_id' => 'O campo author é obrigatório.',
        ];
    }
}
