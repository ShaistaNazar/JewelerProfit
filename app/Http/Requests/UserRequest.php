<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        // DD($request->all());
        $rules = [];
        if ($request->path() == 'api/personal-information' && $request->isMethod('post')) 
        {
            $rules = [

                'owner_fullname'             => 'required|string',
                'owner_email'                => 'required|string',
                'owner_contact'              => 'nullable', // +14155552671 e.g.,
                'owner_address'              => 'nullable|string',
                'owner_shop_name'            => 'required|string',
                'owner_shop_street_address'  => 'nullable|string',
                'owner_shop_zip'             => 'nullable|string',
                'owner_shop_apartment'       => 'nullable|string',
                'owner_shop_city'            => 'nullable|string',
                'owner_shop_contact_no'      => 'nullable|string',
                'sale_staff.*.fullname'      => 'required|string',
                'sale_staff.*.email'         => 'required|email',
                'sale_staff.*.contact_no'    => 'required|string|min:11|max:13',
                'jeweler.*.fullname'         => 'required|string',
                'jeweler.*.email'            => 'required|email',
                'jeweler.*.contact_no'       => 'required|string|min:11|max:13',

            ];
        }
        return $rules;
    }
}
