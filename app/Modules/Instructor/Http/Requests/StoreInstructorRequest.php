<?php

namespace App\Modules\Instructor\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInstructorRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required_if:id,null',
            'phone' => 'required',
            'status' => 'required',
        ];

        // If we are updating an existing instructor, update the rules accordingly
        if ($this->has('id')) {
            $id = $this->get('id');

            // Update the rules for `name` and `email` to ignore the current record's id
            $rules['name'] = [
                'required',
                Rule::unique('users', 'name')->ignore($id, 'id'),
            ];

            $rules['email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id, 'id'),
            ];

            // Remove the password requirement if not setting a new password
            unset($rules['password']);
        }

        return $rules;
    }

    public function messages(): array {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'password.required_if' => 'The password field is required when creating a new instructor.',
            'phone.required' => 'The phone field is required.',
            'status.required' => 'The status field is required.',
        ];
    }
}
