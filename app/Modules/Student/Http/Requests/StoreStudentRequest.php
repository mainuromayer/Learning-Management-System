<?php

namespace App\Modules\Student\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Default validation rules for creating a new student
        $rules = [
            'name' => 'required|unique:users,name',  // Ensures unique name in 'users' table
            'email' => 'required|unique:users,email', // Ensures unique email in 'users' table
            'password' => 'required',  // Only required when creating a new student
            'phone' => 'required',
        ];

        // Check if we are updating an existing student
        if ($this->get('id')) {
            // Fetch the student and user details
            $student = \App\Modules\Student\Models\Student::find($this->get('id'));

            if ($student && $student->user_id) {
                $userId = $student->user_id;  // Get the user ID associated with the student

                // Update name validation: Ignore the current name for this user
                $rules['name'] = [
                    'required',
                    Rule::unique('users', 'name')->ignore($userId),  // Ignore the current name
                ];

                // Update email validation: Ignore the current email for this user
                $rules['email'] = [
                    'required',
                    Rule::unique('users', 'email')->ignore($userId), // Ignore the current email
                ];

                // Remove password requirement for updates
                unset($rules['password']);
            }
        }

        return $rules;
    }

    /**
     * Set the validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'password.required' => 'The password field is required.',
            'phone.required' => 'The phone field is required.',
        ];
    }
}
