<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CustomerRequest extends FormRequest
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
        if ($request_path == 'api/edit-customer') 
        {
            $rules = [

                'id'      => 'required',                
            ];
        }
        if ($request_path == 'api/delete-customer') 
        {
            $rules = [

                'email'      => 'required',                
            ];
        }
        if($request_path == 'api/update-customer' || $request_path == 'api/add-customer'){

            // dd($request->all());
            $id_rule = $request->path() == 'api/update-customer' ? 
            ['id' => 'required|numeric','customer_id' => 'required|string','email' => 'required|email']: 
            ['customer_id' => 'required|string|unique:customers','email' => 'required|email|unique:customers'];

            $rules = Arr::collapse([$id_rule, [

                'firstname'                => 'bail|required|string',
                'lastname'                 => 'required|string',
                // 'spouce_f_name'            => 'sometimes|required|string',
                // 'spouce_l_name'            => 'sometimes|required|string',
                // 'gender'                   => 'required|in:m,f',
                'cell_phone'               => 'required|regex:/(353)[0-9]{9}/|digits:12',
                'alternative'              => 'required|regex:/(353)[0-9]{9}/|digits:12',
                'should_contact'           => 'required|boolean',
                'email'                    => 'required|email',
                'street_address'           => 'required|string',
                'apartment'                => 'required|string',
                'city'                     => 'required|string',
                'zip'                      => 'required|string'

            ]]);

        }

        return $rules;
    }
}
