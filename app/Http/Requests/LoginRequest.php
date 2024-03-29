<?php

namespace App\Http\Requests;

use App\Rules\ValidRecaptcha;
use App\Utilities\StatusUtilities;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Lang;

class LoginRequest extends FormRequest
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
        $data = [
            "email" => "required|email",
            "password" => "required|string",
        ];

        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'code'      => 400,
            'info'      => $validator->messages()->first(),
            'data'      => ['errors' => $validator->messages()->toArray()]
        ]);
        throw new ValidationException($validator, $response);
    }
}
