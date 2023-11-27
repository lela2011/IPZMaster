<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class MediaInfoRequest extends FormRequest
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
            'media_competences' => 'nullable',
            'contact_method' => 'required|array|min:1'
        ];
    }

    public function messages()
    {
        return [
            'contact_method' => 'At least one mean of contact must be selected.'
        ];
    }

    protected function prepareForValidation()
    {
        $temp_media_competences = $this->media_competences;
        array_pop($temp_media_competences);

        $this->merge([
            'media_competences' => $temp_media_competences,
        ]);
    }
}
