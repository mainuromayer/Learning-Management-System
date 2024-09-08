<?php

namespace App\Modules\Course\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest {
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
        $rules['title'] = 'required'; 
        $rules['create_as'] = 'required'; 
        $rules['category'] = 'required'; 
        $rules['course_level'] = 'required'; 
        $rules['pricing_type'] = 'required'; 
        $rules['price'] = 'required'; 

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
            'title.required'         => 'The title field is required.', 
            'create_as.required'         => 'The catagory id field is required.', 
            'category.required'         => 'The catagory id field is required.', 
            'course_level.required'         => 'The course level field is required.', 
            'pricing_type.required'         => 'The Pricing type field is required.', 
            'price.required'         => 'The price field is required.', 
            // 'sub_zone_name.required'  => 'The sub zone name field is required.',
        );
    }
}
