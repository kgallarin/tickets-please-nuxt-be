<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // sanctum is protecting the route
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * Define the validation rules for the store ticket request.
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'data.attributes.title' => 'required|string|min:3|max:255',
            'data.attributes.description' => 'required|string|min:3|max:2000',
            'data.attributes.status' => 'required|string|in:A,C,H,X',
        ];

        if($this->routeIs('api.v1.tickets.store')) {
            $rules['data.relationships.user.data.id'] = 'required|exists:users,id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'data.attributes.status' => "Please select a valid ticket status. A, C, H, X",
            'data.relationships.user.data.id' => "Cannot find user with the provided ID",
        ];
    }
}
