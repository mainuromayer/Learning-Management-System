<?php

namespace App\Modules\Student\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
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
        // $rules['category_id'] = 'required'; 
        $rules['name'] = 'required'; 
        $rules['phone'] = 'required';  
        // $rules['email'] = 'required';  
        // $rules['password'] = 'required';  

        return $rules;
    }

    /**
     * Set the validation message.
     *
     * @return array
     */
    public function messages(): array {
        return array(
            // 'catagory_id.required'         => 'The catagory id field is required.', 
            'name.required'         => 'The name field is required.', 
            'phone.required'         => 'The phone field is required.', 
            // 'email.required'         => 'The email field is required.', 
            // 'password.required'         => 'The password field is required.',  
        );
    }
}
