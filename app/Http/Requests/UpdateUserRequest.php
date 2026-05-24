<?php

namespace App\Http\Requests;

use App\Common\Enums\Message;
use App\Common\Traits\HasFailedValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    use HasFailedValidationResponse;

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
        $rules = [
            'phoneNumber' => 'required|string|regex:/^(?:[+0][1-9])?[0-9]{10,11}$/|unique:users,phone_number,' . auth()->id(),
            'fullName' => 'required|string',
            'jobTitle' => 'required|string',
            'companyName' => 'required|string',
            'type' => 'required|string',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'phoneNumber.regex' => trans(Message::PHONE_SHOULD_NOT_CONTAIN_LETTERS),
        ];
    }
}
