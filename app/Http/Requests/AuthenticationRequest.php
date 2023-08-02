<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthenticationRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [];

		if ($request->path() == 'api/signup') 
		{ 
			$rules = [
				'username' => 'required|string|alpha_dash',
				'fullname' => 'required|string',
				'password' => 'required|string|min:8|max:16',
                'email' => 'required|email',
				'ok_with_policy' => 'required|boolean|in:1'
			];
		}

		if ($request->path() == 'api/login') 
		{
			$rules = [
				'email' => 'required|email',
				'password' => 'required|string|min:8|max:16',
				'remember_me' => 'required|boolean'
			];
		}

		if ($request->path() == 'api/forgot/email') 
		{
			$rules = [
				'email' => 'required|email',
			];
		}

		if ($request->path() == 'api/password/reset') 
		{
			$rules = [
				'email' => 'required|email',
				'password' => 'required|string|confirmed|min:8',
				'token' => 'required|string'
			];
		} 

		if ($request->path() == 'api/password/send-verification-code') 
		{
			$rules = [
				'email' => 'required|email',
			];
		}

		if ($request->path() == 'api/password/change') 
		{
			$rules = [
				'email' => 'required|email',
				'password' => 'required|string|confirmed|min:8',
				'code' => 'required|string|min:6|max:6'
			];
		}
		
		if ($request->path() == 'api/is-user-verified') 
		{
			$rules = [
				'email' => 'required|email',
			];
		}

		if ($request->path() == 'api/resend-email') 
		{
			$rules = [
				'email' => 'required|email',
			];
		}

        return $rules;
    }

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'ok_with_policy.required' => 'You must be okay with terms of service and policy.',
			'ok_with_policy.in' => 'You must be okay with terms of service and policy.',
		];
	}

    // protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
	// {

	// 	$message = $validator->errors()->first();
	// 	$rescode = 412;
	// 	$param = 'Data';
	// 	$values = new \stdClass();
	// 	$response = new JsonResponse([
	// 		'response_header' => [
	// 			'response_code' => $rescode,
	// 			'reponse_message' =>  $message
	// 		],
	// 	],  412);

	// 	throw new \Illuminate\Validation\ValidationException($validator, $response);
	// }
}
