<?php

namespace App\Http\Requests\Auth;

use App\Traits\APIResponse;
use Illuminate\Foundation\Http\FormRequest;

class ResentOtpRequest extends FormRequest
{
    use APIResponse;

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
            'phone' => ['required', 'exists:users,phone', 'numeric', 'regex:/^01[0-9]{9}$/'],
        ];
    }
}
