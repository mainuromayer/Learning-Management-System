<?php

namespace App\Modules\AboutUs\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAboutUsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
        ];
    }

    public function messages():array
    {
        return [
            'title.required' => 'The title is required.',
            'description.required'          => 'The description field is required.',
        ];
    }

}

