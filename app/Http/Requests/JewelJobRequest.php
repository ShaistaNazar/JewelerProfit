<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class JewelJobRequest extends FormRequest
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
        $rules = [];

        
        if ($request->path() == 'api/dashboard/get-jobs-per-jeweler') 
        {
            $rules = [

                'jeweler_id'                 => 'required|numeric',

            ];
        }

        if($request->path() == 'api/dashboard/get-annual-income-of-shop-jewelers' || $request->path() == 'api/dashboard/get-shop-jobs-by-status')
        {
            $rules = [

                'shop_id'                    => 'required|numeric',

            ];

        }

        return $rules;
    }
}
