<?php

namespace App\Modules\Lesson\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lesson_type' => 'required',
            'title'=>'required|string|max:255',
            'section' => 'required|exists:course_sections,id',
            'status' => 'required',
        ];
    }

    public function messages():array
    {
        return [
            'lesson_type.required' => "The lesson type field is required",
            'title.required' => "The title field is required",
            'section.required' => "The section field is required",
            'status.required' => "The status field is required"
        ];
    }
}
