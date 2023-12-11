<?php

namespace App\Http\Requests;

use App\Rules\OrcidValidation;
use Illuminate\Foundation\Http\FormRequest;

class PersonalDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // allows form submits from every user
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
            'orcid' => ['nullable', new OrcidValidation],
            'website' => 'nullable|url',
            'cv_english' => 'nullable',
            'cv_german' => 'nullable',
            'research_focus_english' => 'nullable',
            'research_focus_german' => 'nullable',
            'research_areas' => 'nullable',
            'transv_research_prios' => 'nullable'
        ];
    }

    protected function prepareForValidation()
    {
        // merges the array into a hyphen-separated string
        $temp_orcid = implode('-', $this->orcid);
        $temp_orcid = $temp_orcid === "---" ? '' : $temp_orcid;

        // merges the correction with the
        $this->merge([
            'research_areas' => filterEmptyArray($this->research_areas),
            'orcid' => $temp_orcid,
            'research_areas' => $this->research_areas ?? [],
            'transv_research_prios' => $this->transv_research_prios ?? []
        ]);
    }
}
