<?php

namespace App\Http\Requests;

use App\Common\Enums\Message;
use App\Common\Traits\HasFailedValidationResponse;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
        return [
            'reason' => 'required|string|in:quote,meeting,support' ,
            'siteUrl' => 'required|url',
            'companyName' => 'nullable|string|max:255',
            'services' => 'required|string|in:storage,power,data,payment,nova,cloud',
            'message' => 'required|string',
        ];
    }
}
