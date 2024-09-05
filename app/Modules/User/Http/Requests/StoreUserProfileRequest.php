<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserProfileRequest extends FormRequest {
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
        $rules['name'] = 'required';
        $rules['email'] = 'required';
        if ( $this->request->get( 'id' ) ) {
            $id = $this->request->get( 'id' );
            // Update name rule to ignore the current record's id
            $rules['name'] = array(
                'required',
                Rule::unique( 'users', 'name' )->ignore( $id ),
            );

            // Update email rule to ignore the current record's id
            $rules['email'] = array(
                'required',
                Rule::unique( 'users', 'email' )->ignore( $id ),
            );
        }
        return $rules;

    }

    /**
     * Set the validation message.
     *
     * @return array
     */
    public function messages(): array {
        return array(
            'image.required' => 'Image field is required.',
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',

        );
    }
}
