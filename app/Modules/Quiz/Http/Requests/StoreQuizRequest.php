<?php

namespace App\Modules\Quiz\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
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
            'title'=>'required|string|max:255',
            'section' => 'required|exists:course_sections,id',
            'status' => 'required',
            'total_mark' => 'required|numeric',
            'pass_mark' => 'required|numeric',
            'retake' => 'required|numeric',
            'hours' => 'required|numeric|min:0',
            'minutes' => 'required|numeric|min:0',
            'seconds' => 'required|numeric|min:0',
        ];
    }

    public function messages():array
    {
        return [
            'title.required' => "The title field is required",
            'section.required' => "The section field is required",
            'status.required' => "The status field is required",
            'hours.required' => "The hours field is required",
            'hours.numeric' => 'The hours must be a number.',
            'hours.min' => 'The hours must be at least 0.',
            'minutes.required' => "The minutes field is required",
            'minutes.numeric' => 'The minutes must be a number.',
            'minutes.min' => 'The minutes must be at least 0.',
            'seconds.required' => "The seconds field is required",
            'seconds.numeric' => 'The seconds must be a number.',
            'seconds.min' => 'The seconds must be at least 0.',
            'total_mark.required' => "The total mark field is required",
            'total_mark.numeric' => 'The total mark must be a number.',
            'pass_mark.required' => "The pass mark field is required",
            'pass_mark.numeric' => 'The pass mark must be a number.',
            'retake.required' => "The retake field is required",
            'retake.numeric' => 'The retake must be a number.',
        ];
    }
}
