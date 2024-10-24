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
        $rules['category'] = 'required|exists:categories,id';
        $rules['instructor'] = 'required|exists:instructors,id';
        $rules['title'] = 'required';
        $rules['create_as'] = 'required';
        $rules['course_level'] = 'required';
        $rules['pricing_type'] = 'required';
        $rules['price'] = 'required';
        $rules['status'] = 'required';

        return $rules;
    }

    /**
     * Set the validation message.
     *
     * @return array
     */
    public function messages(): array {
        return [
            'category.required'            => 'The category field is required.',
            'instructor.required'          => 'The instructor field is required.',
            'title.required'               => 'The title field is required.',
            'create_as.required'           => 'The category id field is required.',
            'course_level.required'        => 'The course level field is required.',
            'pricing_type.required'        => 'The Pricing type field is required.',
            'price.required'               => 'The price field is required.',
            'status.required'              => 'The status field is required.',
        ];
    }
}
