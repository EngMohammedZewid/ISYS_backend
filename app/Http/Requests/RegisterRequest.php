<?php

namespace App\Http\Requests;

use App\Common\Enums\Message;
use App\Common\Traits\HasFailedValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->where(function ($query) {
                    $query->where('admin_promoted', false);
                }),
                function ($attribute, $value, $fail) {
                    if (str_contains($value, '@')) {
                        $domain = explode('@', $value)[1];
                        if (in_array($domain, $this->getFreeEmailProviders())) {
                            $fail(trans(Message::FREEEMAILPROVIDERSARENOTALLOWED));
                        }
                    }
                },
            ],
            'phoneNumber' => 'nullable|string|regex:/^(?:[+0][1-9])?[0-9]{10,11}$/|unique:users,phone_number',
            'password' => 'required|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'fullName' => 'required|string',
            'jobTitle' => 'nullable|string',
            'companyName' => 'required|string',
            'type' => 'required|string',
        ];

        $rules['email'][] = Rule::notIn($this->getFreeEmailProviders());

        return $rules;
    }

    public function messages()
    {
        return [
            'phoneNumber.regex' => trans(Message::PHONE_SHOULD_NOT_CONTAIN_LETTERS),
            'email.not_in' => trans(Message::FREEEMAILPROVIDERSARENOTALLOWED),
        ];
    }

    private function getFreeEmailProviders()
    {
        return [
            'gmail.com',
            'yahoo.com',
            'hotmail.com',
            'outlook.com',
            'aol.com',
            'protonmail.com',
            'tutanota.com',
            'icloud.com',
            'zoho.com',
        ];
    }
}
