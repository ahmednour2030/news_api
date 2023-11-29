<?php

namespace App\Http\Requests\Api;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class IndexNews extends FormRequest
{
    use ApiResponse;

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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'sometimes|date_format:m/d/Y|nullable',
            'category' => 'string|nullable',
            'source' => 'string|nullable',
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'date' => $this->route('date'),
                'category' => $this->route('category'),
                'source' => $this->route('source'),
            ]);
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        $this->apiResponseValidation($validator);
    }
}
