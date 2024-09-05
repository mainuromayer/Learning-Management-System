<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAuthPasswordRequest extends FormRequest {
    /**
     * Determine if the department is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array {
        $rules['old_password'] = 'required';
        $rules['new_password'] = 'required';

        return $rules;
    }

    /**
     * Set the validation message.
     *
     * @return array
     */
    public function messages(): array {
        return array(
            'old_password.required' => 'Old Password field is required.',
            'new_password.required' => 'Old Password field is required.',
        );
    }
}
