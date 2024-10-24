<?php

namespace App\Modules\Assignment\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'instructor' => 'required|exists:instructors,id',
            'status' => 'required',
        ];
    }

    public function messages():array
    {
        return [
            'title.required' => 'The title is required.',
            'instructor.required'          => 'The instructor field is required.',
            'status.required' => 'The status is required.',
        ];
    }

}

