<?php

namespace App\Modules\Category\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'keywords' => 'nullable|array',
            'keywords.*' => 'string|max:255',
            'description' => 'nullable|string',
//            'thumbnail' => 'nullable|image|max:2048',
//            'category_logo' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'category_name.required' => 'The category name field is required.',
            'icon.required' => 'The icon field is required.',
            'keywords.array' => 'Keywords must be an array.',
            'keywords.*.string' => 'Each keyword must be a string.',
            'keywords.*.max' => 'Each keyword may not be greater than 255 characters.',
        ];
    }
}

