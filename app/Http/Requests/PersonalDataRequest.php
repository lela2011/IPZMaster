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
            'orcid' => ['nullable', new OrcidValidation],
            'cv' => 'nullable',
            'research_areas' => 'nullable',
            'transv_research_prio' => 'required'
        ];
    }

    protected function prepareForValidation()
    {
        // removes the last item from array
        $temp_research_ares = $this->research_areas;
        array_pop($temp_research_ares);

        // merges the array into a hyphen-separated string
        $temp_orcid = implode('-', $this->orcid);
        $temp_orcid = $temp_orcid === "---" ? '' : $temp_orcid;

        // merges the correction with the
        $this->merge([
            'research_areas' => $temp_research_ares,
            'orcid' => $temp_orcid
        ]);
    }
}
