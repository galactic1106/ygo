<?php

namespace App\Http\Requests;

use App\Services\YgoApiProxyService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CardDataRequest extends FormRequest
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
    public function rules(YgoApiProxyService $apiService): array
    {
        return [
            // --- Basic Card Identifiers ---
            'name' => ['nullable', 'string', 'prohibits:id'],
            'fname' => ['nullable', 'string', 'prohibits:id'],
            'id' => [
                'nullable',
                'string',
                'prohibits:name,fname',
                function ($attribute, $value, $fail) {
                    $ids = array_map('trim', explode(',', $value));
                    foreach ($ids as $id) {
                        if (!is_numeric($id) || strlen($id) !== 8) {
                            $fail("The '$attribute' field must be a comma-separated list of numeric IDs, each up to 8 digits long.");
                            return;
                        }
                    }
                },
            ],
            'konami_id' => ['nullable', 'string'],

            // --- Card Properties ---
            'atk' => ['nullable', 'string', 'regex:/^(lt|lte|gt|gte)?[0-9]+$/i'],
            'def' => ['nullable', 'string', 'regex:/^(lt|lte|gt|gte)?[0-9]+$/i'],
            'level' => ['nullable', 'string', 'regex:/^(lt|lte|gt|gte)?[0-9]+$/i'],
            'scale' => ['nullable', 'integer'],
            'link' => ['nullable', 'integer'],
            'has_effect' => ['nullable', 'boolean'],

            // --- Relational & Categorical Data (with custom validation) ---
            'type' => $this->buildListValidationRule($apiService->getTypes('all')),
            'race' => $this->buildListValidationRule($apiService->getRaces('all')),
            'attribute' => $this->buildListValidationRule($apiService->getAttributes()),
            'linkmarker' => $this->buildListValidationRule($apiService->getLinkMarkers()),

            'archetype' => ['nullable', 'string', Rule::in($apiService->getArchetypes())],
            'cardset' => ['nullable', 'string'],

            // --- Filtering & Sorting (case-insensitive) ---
            'banlist' => ['nullable', 'string', $this->caseInsensitiveRule($apiService->getBanLists())],
            'sort' => ['nullable', 'string', $this->caseInsensitiveRule($apiService->getSortables())],
            'format' => ['nullable', 'string', $this->caseInsensitiveRule($apiService->getFormats())],

            // --- Date Filtering ---
            'startdate' => ['nullable', 'date_format:Y-m-d'],
            'enddate' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:startdate'],
            'dateregion' => ['nullable', 'string', $this->caseInsensitiveRule($apiService->getRegions())],

            // --- Miscellaneous Options ---
            'misc' => ['nullable', 'string', Rule::in(['yes'])],
            'staple' => ['nullable', 'string', Rule::in(['yes'])],
        ];
    }

    /**
     * Builds a validation rule for a case-insensitive, comma-separated list.
     *
     * @param array<int, string> $validValues The list of acceptable values.
     * @return callable
     */
    private function buildListValidationRule(array $validValues): callable
    {
        return function ($attribute, $value, $fail) use ($validValues) {
            // Create a lowercase map of valid values for efficient, case-insensitive lookup.
            $lowerCaseValidValues = array_map('strtolower', $validValues);

            $inputValues = array_map('trim', explode(',', $value));
            $invalidOriginals = [];

            foreach ($inputValues as $inputValue) {
                if (!in_array(strtolower($inputValue), $lowerCaseValidValues)) {
                    $invalidOriginals[] = $inputValue;
                }
            }

            if (!empty($invalidOriginals)) {
                $fail("The following values for '$attribute' are invalid: " . implode(', ', $invalidOriginals));
            }
        };
    }

    /**
     * Creates a case-insensitive "in" rule for single value fields.
     *
     * @param array<int, string> $validValues
     * @return callable
     */
    private function caseInsensitiveRule(array $validValues): callable
    {
        return function ($attribute, $value, $fail) use ($validValues) {
            // Perform a case-insensitive search in the valid values array.
            if (collect($validValues)->first(fn($v) => strcasecmp($v, $value) === 0) === null) {
                $fail("The selected '$attribute' is invalid.");
            }
        };
    }
}
