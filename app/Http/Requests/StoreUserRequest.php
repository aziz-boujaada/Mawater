<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required','string' , Password::min(8)->numbers()->letters()],
            'role' => 'required|in:admin,collector,repair_agnet,villager',
            'phone' => 'required|string|max:15',
            'cin' => 'required_if:role,villager|string|max:20',
            'subscription_status' => 'required_if:role,villager|in:subscribed,not_subscribed',
            'address' => 'required_if:role,villager|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'cin.required_if' => 'CIN is required for Villager role',
            'address.required_if' => 'Address is required for Villager role',
        ];
    }
}
