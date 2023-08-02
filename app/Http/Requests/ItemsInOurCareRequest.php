<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ItemsInOurCareRequest extends FormRequest
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
        $request_path = $request->path();
        if ($request_path == 'api/dashboard/store-item-in-care') 
        {
            $rules = [
                'envelope_id'                 => 'required|unique:items_in_our_care',
                'customer_email'              => 'required|string',
                'item_description'            => 'required|string',
                'customer_stated_value'       => 'required|string', // +14155552671 e.g.,
                'stones_quality_description'  => 'required|string',
                'is_guarranteed'              => 'required|boolean',
                'is_qualiteed'                => 'required|boolean',
                'photo'                       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }
        if ($request_path == 'api/dashboard/get-customer-items-in-shop') 
        {
            $rules = [

                'customer_id'                 => 'required|string',
      
            ];
        }
        if ($request_path == 'api/dashboard/delete-items-in-shop-care') 
        {
            $rules = [

                'item_id'                    => 'required|string',
      
            ];
        }
        return $rules;
    }
}
