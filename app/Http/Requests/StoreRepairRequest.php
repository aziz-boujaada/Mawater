<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRepairRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'meter_id' => 'nullable|exists:meters,id',
            'problem_description' => 'required|string|max:1000',
            'repair_cost' => 'required|numeric|min:0',
            'status' => 'required|in:in progress,repaired'
        ];
    }

    public function messages(): array
    {
        return [
            'meter_id.exists' => 'The selected meter does not exist.',
            'repair_agent_id.exists' => 'The selected repair agent does not exist.',
            'problem_description.required' => 'Problem description is required.',
            'repair_cost.required' => 'Repair cost is required.',
            'repair_cost.numeric' => 'Repair cost must be a valid number.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be in progress or repaired.',
        ];
    }
}
