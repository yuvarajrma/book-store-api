<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'author' => 'nullable|string',
            'publication_year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'isbn' => ['required', 'string', 'regex:/^(?:(?:\d{9}[\d|X])|(?:\d{13}))$/', 'unique:books,isbn'],
        ];
    }
}
