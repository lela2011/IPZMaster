<?php

namespace App\Http\Requests;

use App\Rules\OrcidValidation;
use App\Rules\PhoneValidation;
use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

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
            'phone' => ['nullable', new PhoneValidation],
            'cv_english' => 'nullable',
            'cv_german' => 'nullable',
            'research_focus_english' => 'nullable',
            'research_focus_german' => 'nullable',
            'research_areas' => 'nullable|array',
            'research_areas.*' => 'exists:research_areas,id',
            'employment_type' => 'nullable|exists:employment_types,id',
            'transv_research_prios' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'website.url' => 'The website must be a valid URL.',
            'research_areas.*.exists' => 'The selected research area is invalid.',
            'employment_type.exists' => 'The selected employment type is invalid.'
        ];
    }

    protected function prepareForValidation()
    {
        // merges the array into a hyphen-separated string
        $temp_orcid = implode('-', $this->orcid);
        $temp_orcid = $temp_orcid === "---" ? '' : $temp_orcid;

        // trims the phone number and adds the country code
        $phone = trim("+41 " . $this->phone);
        if($phone === "+41") $phone = "";


        // allow target="_blank" and target="_self" in links
        $config = [
            'Attr.AllowedFrameTargets' => ['_blank', '_self']
        ];
        
        // merges the correction with the
        $this->merge([
            'research_areas' => filterEmptyArray($this->research_areas),
            'orcid' => $temp_orcid,
            'phone' => $phone,
            'research_areas' => $this->research_areas ?? [],
            'transv_research_prios' => $this->transv_research_prios ?? [],
            'cv_english' => Purifier::clean($this->cv_english, $config) ?? '',
            'cv_german' => Purifier::clean($this->cv_german, $config) ?? '',
            'research_focus_english' => Purifier::clean($this->research_focus_english, $config) ?? '',
            'research_focus_german' => Purifier::clean($this->research_focus_german, $config) ?? '',
        ]);
    }
}
