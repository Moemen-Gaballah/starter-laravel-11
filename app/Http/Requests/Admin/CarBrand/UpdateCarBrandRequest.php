<?php

namespace App\Http\Requests\Admin\CarBrand;

use App\Traits\APIResponse;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCarBrandRequest extends FormRequest
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
        $carBrandId = $this->route('car_brand');
        return [
            "name_ar" => 'required|string|max:255|unique:car_brands,name_ar,'.$carBrandId,
            "name_en" => 'required|string|max:255|unique:car_brands,name_en,'.$carBrandId,
            "image" => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
