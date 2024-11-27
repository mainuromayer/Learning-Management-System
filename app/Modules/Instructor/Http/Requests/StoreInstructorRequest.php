<?php

namespace App\Modules\Instructor\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInstructorRequest extends FormRequest
{
    public function authorize(): bool
    {
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

        if ($this->get('id')) {
            // Check if we're updating an existing instructor
            $instructor = \App\Modules\Instructor\Models\Instructor::find($this->get('id'));

            if ($instructor && $instructor->user_id) {
                $userId = $instructor->user_id; // Get the associated user's ID

                // Update name validation: Ignore the current user's name during the update
                $rules['name'] = [
                    'required',
                    Rule::unique('users', 'name')->ignore($userId),  // Ignore the current name for this user
                ];

                // Update email validation: Ignore the current user's email during the update
                $rules['email'] = [
                    'required',
                    Rule::unique('users', 'email')->ignore($userId), // Ignore the current email for this user
                ];

                // Remove password requirement for updates
                unset($rules['password']);
            }
        }

        return $rules;
    }

    public function messages(): array
    {
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
