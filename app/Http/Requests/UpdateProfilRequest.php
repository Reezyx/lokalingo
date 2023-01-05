<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\ValidRecaptcha;
use App\Utilities\StatusUtilities;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Lang;


class UpdateProfilRequest extends FormRequest
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
        $users = User::all();
        foreach ($users as $user) {
            $data = [
                "email"     => "required|email|unique:users,email",
                "username"  => "required|string|max:20|unique:users,username",
                "password"  => "required|string|max:12",
                "password_confirmation" => "required|string|same:password",
                "full_name" => "required|string|max:100",
            ];
        }
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
