<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePage extends FormRequest
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
            'title' => 'required|max:100',
            'description' => 'required|max:255',
            'visibility' => 'required|max:11',
            'path' => 'required|max:100|unique:pages,path',
            'status' => 'required|integer|size:1',
            'author' => 'required|integer',
            'content' => 'array',
            'fields' => 'array'
        ];
    }
}
