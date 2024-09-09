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
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'phone' => 'required',
        ];

        if ($this->user_id) {
            $id = $this->user_id;

            unset($rules['password']);

            $rules['name'] = [
                'required',
                Rule::unique('users', 'name')->ignore($id),
            ];

            $rules['email'] = [
                'required',
                Rule::unique('users', 'email')->ignore($id),
            ];
        }

        return $rules;
    }



    public function messages(): array {
        return [
            'name.required'          => 'The name field is required.',
            'email.required'         => 'The email field is required.',
            'password.required'      => 'The password field is required.',
            'phone.required'      => 'The phone field is required.',
        ];
    }
}
