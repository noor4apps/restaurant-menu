<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
                'name' => ['required'],
                'discount' => ['nullable'],
                'price' => ['required'],
                'menu_id' => ['required', 'exists:menus,id'],
            ];
        } else {
            return [
                'name' => ['sometimes', 'required'],
                'discount' => ['nullable'],
                'price' => ['sometimes', 'required'],
                'menu_id' => ['sometimes', 'required', 'exists:menus,id'],
            ];
        }
    }
}
