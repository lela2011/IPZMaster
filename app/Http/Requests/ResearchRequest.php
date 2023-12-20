<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResearchRequest extends FormRequest
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
            'title' => 'required',
            'title_original' => 'nullable|different:title',
            'publish' => 'required|boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'summary' => 'required_without:summary_urls',
            'summary_urls' => 'required_without:summary',
            'summary_urls.*' => 'nullable|url|distinct',
            'zora_ids' => 'nullable',
            'zora_ids.*' => 'required|numeric|distinct',
            'publication_url' => 'nullable|url',
            'project_urls' => 'nullable',
            'project_urls.*' => 'required|url|distinct',
            'fundings' => 'nullable',
            'fundings.*' => 'required|distinct',
            'institutions' => 'nullable',
            'institutions.*' => 'required|distinct',
            'countrys' => 'nullable',
            'countrys.*' => 'required|distinct',
            'leaders' => 'required',
            'leaders.*' => 'required|distinct',
            'members' => 'nullable',
            'members.*' => 'required|distinct',
            'contacts' => 'nullable',
            'contacts.*' => 'required|distinct',
            'contributors' => 'nullable',
            'contributors.*' => 'required|distinct',
            'transv_research_prios' => 'nullable',
            'transv_research_prios.*' => 'required|distinct',
            'research_areas' => 'nullable',
            'research_areas.*' => 'required|distinct',
            'keywords' => 'nullable',
            'keywords.*' => 'nullable|distinct'
        ];
    }

    public function messages()
    {
        // set custom error messages
        return [
            'title_original.different' => "The original title may not be the same as it's english translation. If the original language is English consider removing the original title.",
            'start_date.required' => 'Please provide a time frame for the project.',
            'start_date.date' => 'The provided start date is not valid.',
            'end_date.required' => 'Please provide a time frame for the project.',
            'end_date.date' => 'The provided end date is not valid.',
            'summary.required_without' => "Add a description of the research project or provide summary links instead. Both may be provided at the same time.",
            'summary_urls.required_without' => "Add summary links or provide a description of the research project. Both may be provided at the same time.",
            'summary_urls.*.url' => 'The provided summary link is not a valid url.',
            'summary_urls.*.distinct' => 'The provided summary link already exists.',
            'zora_ids.*.numeric' => 'The provided Zora ID is not valid.',
            'zora_ids.*.distinct' => 'The provided Zora ID already exists.',
            'publication_url.url' => 'The provided publication links is not a valid url.',
            'project_urls.*.url' => 'The provided project link is not a valid url.',
            'project_urls.*.distinct' => 'The provided project url already exists.',
            'leaders.required' => 'Please define at least one project leader.',
            'fundings.*.distinct' => 'The provided source of funding already exists.',
            'institutions.*.distinct' => 'The provided institution already exists.',
            'countrys.*.distinct' => 'The provided country already exists.',
            'contributors.*.distinct' => 'The provided contributor already exists.',
            'keywords.*.distinct' => 'The provided keyword already exists.'
        ];
    }

    protected function prepareForValidation()
    {
        // prepares data for validation
        $this->merge([
            "summary_urls" => filterEmptyArray($this->summary_urls),
            "zora_ids" => filterEmptyArray($this->zora_ids),
            "project_urls" => filterEmptyArray($this->project_urls),
            "fundings" => filterEmptyArray($this->fundings),
            "institutions" => filterEmptyArray($this->institutions),
            "countrys" => filterEmptyArray($this->countrys),
            "leaders" => $this->leaders ?? [],
            "members" => $this->members ?? [],
            "contacts" => $this->contacts ?? [],
            "transv_research_prios" => $this->transv_research_prios ?? [],
            "research_areas" => $this->research_areas ?? [],
            "contributors" => filterEmptyArray($this->contributors),
            "keywords" => filterEmptyArray($this->keywords),
            "start_date" => null,
            "end_date" => null,
            "publish" => boolval($this->publish)
        ]);

        // converts input date range to php date format
        $formattedDateRange = $this->parseDateRange($this->date_range);

        // checks for errors
        if($formattedDateRange['success']) {
            $this->merge([
                "start_date" => $formattedDateRange['start'],
                "end_date" => $formattedDateRange['end']
            ]);
        }

        // removes date string from validation
        unset($this['date_range']);
    }

    private function parseDateRange($selectedDateRange) {
        // splits string at " to "
        $dates = explode(" to ", $selectedDateRange);

        try {
            // tries to read date from input string
            $startDate = date_create_from_format('l, jS F Y', trim($dates[0]));
            $endDate = date_create_from_format('l, jS F Y', trim($dates[1]));

            // formats dates to sql format
            $formattedStartDate = $startDate->format('Y-m-d');
            $formattedEndDate = $endDate->format('Y-m-d');

            // returns success and formated dates
            return [
                'success' => true,
                'start' => $formattedStartDate,
                'end' => $formattedEndDate
            ];
        } catch (\Exception $e) {
            // returns failure
            return [
                'success' => false
            ];
        }
    }
}
