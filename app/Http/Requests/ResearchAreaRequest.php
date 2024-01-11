<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

class ResearchAreaRequest extends FormRequest
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
        // sets validation rules for form data
        return [
            'description_english' => 'nullable|string',
            'description_german' => 'nullable|string',
            'research_focus_english' => 'nullable|string',
            'research_focus_german' => 'nullable|string',
            'teaching_english' => 'nullable|string',
            'teaching_german' => 'nullable|string',
            'support_english' => 'nullable|string',
            'support_german' => 'nullable|string'
        ];
    }

    public function prepareForValidation(): void
    {
        // cleans the form data
        $this->merge([
            'description_english' => Purifier::clean($this->description_english) ?? '',
            'description_german' => Purifier::clean($this->description_german) ?? '',
            'research_focus_english' => Purifier::clean($this->research_focus_english) ?? '',
            'research_focus_german' => Purifier::clean($this->research_focus_german) ?? '',
            'teaching_english' => Purifier::clean($this->teaching_english) ?? '',
            'teaching_german' => Purifier::clean($this->teaching_german) ?? '',
            'support_english' => Purifier::clean($this->support_english) ?? '',
            'support_german' => Purifier::clean($this->support_german) ?? '',
        ]);
    }
}
