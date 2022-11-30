<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'name' => ['required', 'unique:menus,name,' . $this->id],
                'discount' => ['nullable'],
                'type' => ['required', Rule::in(['category', 'item'])],
                'menu_id' => ['nullable', 'exists:menus,id'],
            ];
        } else {
            return [
                'name' => ['sometimes', 'required','unique:menus,name,' . $this->id],
                'discount' => ['nullable'],
                'type' => ['sometimes', 'required', Rule::in(['category', 'item'])],
                'menu_id' => ['nullable', 'exists:menus,id'],
            ];
        }
    }
}
