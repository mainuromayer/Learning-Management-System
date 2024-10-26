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
            'hours' => 'numeric|min:0',
            'minutes' => 'numeric|min:0',
            'seconds' => 'numeric|min:0',
        ];
    }

    public function messages():array
    {
        return [
            'lesson_type.required' => "The lesson type field is required",
            'title.required' => "The title field is required",
            'section.required' => "The section field is required",
            'status.required' => "The status field is required",
            'hours.numeric' => 'The hours must be a number.',
            'hours.min' => 'The hours must be at least 0.',
            'minutes.numeric' => 'The minutes must be a number.',
            'minutes.min' => 'The minutes must be at least 0.',
            'seconds.numeric' => 'The seconds must be a number.',
            'seconds.min' => 'The seconds must be at least 0.',
        ];
    }
}
