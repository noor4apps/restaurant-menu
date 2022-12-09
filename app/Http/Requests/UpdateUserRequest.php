<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
                'name' => ['required', 'string'],
                'email' => ['required', 'string', 'email', 'unique:users,email,' . $this->id],
                'password' => ['nullable', 'string', 'min:8'],
            ];
        } else {
            return [
                'name' => ['sometimes', 'string'],
                'email' => ['sometimes', 'required', 'string', 'email', 'unique:users,email,' . $this->id],
                'password' => ['sometimes', 'required', 'string', 'min:8'],
            ];
        }
    }
}
