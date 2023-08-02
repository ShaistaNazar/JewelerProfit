<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class GeneralPricingRequest extends FormRequest
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
        if ($request->path() == 'api/personal-information' && $request->isMethod('post')) 
        {
            $rules = [

                'sku'     => 'required|numeric',
                'shop_id' => 'required|numeric',

            ];
        }

        if ($request->path() == 'api/search-for-sku') 
        {
            $rules = [
                'sku'     => 'required|numeric',
            ];
        }

        return $rules;
        
    }
}
