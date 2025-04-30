<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'text_comment' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'text_comment.required' => 'O campo comentário é obrigatório.',
            'text_comment.string' => 'O campo comentário deve ser uma string.',
            'text_comment.max' => 'O campo comentário não pode ter mais de 255 caracteres.',
        ];
    }
}
