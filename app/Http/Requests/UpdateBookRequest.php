<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
        $bookId = $this->route('book')->id;
        return [
            'title' => 'required|string',
            'author' => 'nullable|string',
            'publication_year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'isbn' => [
                'required',
                'string',
                'regex:/^(?:(?:\d{9}[\d|X])|(?:\d{13})|(?:\d{1}-\d{3}-\d{5}-[\d|X]))$/',
                'unique:books,isbn,' . $bookId  // to skip the current book isbn check
            ],
        ];
    }

    /**
     * ISBN-10:
     * 
     * 0-321-75104-3
     * 0-596-52682-X
     * 0-7356-1967-0
     * 
     * ISBN-13:
     * 
     * 978-0-321-75104-1
     * 978-0-13-235088-4
     *  978-0-7356-1967-8
     */
}
