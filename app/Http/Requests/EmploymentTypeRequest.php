<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmploymentTypeRequest extends FormRequest
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
        $id = $this->route('employmentType');

        return [
            'english' => 'required','string', Rule::unique('employment_types', 'english')->ignore($id),
            'german' => 'required','string', Rule::unique('employment_types', 'german')->ignore($id),
            'singular' => 'required','string', Rule::unique('employment_types', 'singular')->ignore($id),
            'url_english' => 'required|url',
            'url_german' => 'required|url',
            'has_personal_page' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'english.required' => 'The English name is required.',
            'english.unique' => 'The English name has already been taken.',
            'german.required' => 'The German name is required.',
            'german.unique' => 'The German name has already been taken.',
            'singular.required' => 'The singular name is required.',
            'singular.unique' => 'The singular name has already been taken.',
            'url_english.required' => 'The English URL is required.',
            'url_english.url' => 'The English URL must be a valid URL.',
            'url_german.required' => 'The German URL is required.',
            'url_german.url' => 'The German URL must be a valid URL.',
            'has_personal_page.required' => 'The personal page field is required.',
            'has_personal_page.boolean' => 'The personal page field must be true or false.',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'url_english' => $this->removeFileTypeAndAppendSlash($this->url_english),
            'url_german' => $this->removeFileTypeAndAppendSlash($this->url_german),
            'has_personal_page' => $this->has_personal_page ? 1 : 0,
        ]);
    }

    function removeFileTypeAndAppendSlash($url) {
        // Parse the URL to get information about the path
        $urlParts = parse_url($url);

        if (isset($urlParts['path'])) {
            // Get the path info
            $pathInfo = pathinfo($urlParts['path']);

            // Check if the path has a file extension
            if (isset($pathInfo['extension'])) {
                // Remove the file extension
                $pathWithoutExtension = rtrim($urlParts['path'], '.' . $pathInfo['extension']);
                // Append a slash to the end of the path
                $pathWithSlash = rtrim($pathWithoutExtension, '/') . '/';
            } else {
                // If there's no file extension, just append a slash to the end of the path
                $pathWithSlash = rtrim($urlParts['path'], '/') . '/';
            }

            // Update the path in the URL
            $urlParts['path'] = $pathWithSlash;
        } else {
            $urlParts['host'] = rtrim($urlParts['host'], '/') . '/';
        }

        // Rebuild the URL
        $updatedUrl = $urlParts['scheme'] . '://' . $urlParts['host'] . $urlParts['path'];

        return $updatedUrl;
    }
}
