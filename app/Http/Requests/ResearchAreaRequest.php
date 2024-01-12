<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
        $id = $this->route('researchArea');

        // sets validation rules for form data
        return [
            'english' => 'required','string', Rule::unique('research_areas', 'english')->ignore($id),
            'german' => 'required','string', Rule::unique('research_areas', 'german')->ignore($id),
            'url_english' => 'required','url', Rule::unique('research_areas', 'url_english')->ignore($id),
            'url_german' => 'required','url', Rule::unique('research_areas', 'url_german')->ignore($id),
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

    // sets custom error messages
    public function messages()
    {
        return [
            'english.required' => 'Please enter a name for the research area in English.',
            'english.unique' => 'This research area already exists.',
            'german.required' => 'Please enter a name for the research area in German.',
            'german.unique' => 'This research area already exists.',
            'url_english.required' => 'Please enter a URL for the research area in English.',
            'url_english.unique' => 'This URL already exists.',
            'url_english.url' => 'Please enter a valid URL.',
            'url_german.required' => 'Please enter a URL for the research area in German.',
            'url_german.unique' => 'This URL already exists.',
            'url_german.url' => 'Please enter a valid URL.',
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
