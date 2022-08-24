<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Rules\PhoneNumber;

class UserUpdateRequest extends FormRequest
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
        $dt = new Carbon();
        $before = $dt->subYears(16)->format('Y/m/d');
        return [
            'name' => 'required',
            'email' => [Rule::unique("users","email")->ignore(request("id"))->whereNull('deleted_at'),'required'],
            'type' => 'required',
            'phone' => ['required','numeric',new PhoneNumber],
            'dob'=>'nullable|date|before:' . $before
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation Error!',
            'errors' => $validator->errors()
        ],422));
    }

    public function messages()
    {
        return [
            'dob.before' => "Your age must be greater than 16",
        ];
    }
}
