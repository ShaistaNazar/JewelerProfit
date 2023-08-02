<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class VendorRequest extends FormRequest
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
        if ($request_path == 'api/edit-vendor') 
        {
            $rules = [

                'id'      => 'required',                
            ];
        }
        if ($request_path == 'api/delete-vendor') 
        {
            $rules = [

                'email'      => 'required',                
            ];
        }
        if($request_path == 'api/update-vendor' || $request_path == 'api/add-vendor'){


            $id_rule = $request->path() == 'api/update-vendor' ? 
            ['id' => 'required|numeric','email' => 'required|email']: 
            ['email' => 'required|email|unique:users'];

            $rules = Arr::collapse([$id_rule, [

                'fullname'                 => 'bail|required|string',
                'gender'                   => 'required|in:m,f',
                'contact_no'               => 'required|regex:/(353)[0-9]{9}/|digits:12',
                'address'                  => 'required|string',

            ]]);

        }

        if($request_path == 'api/update-vendor-of-shop'){

            $id_rule = $request->path() == 'api/update-vendor' ? 
            ['vendor.id' => 'required|numeric','vendor.email' => 'required|email']: 
            ['vendor.email' => 'required|email|unique:users'];
            // dd($request->all());

            $rules = Arr::collapse([$id_rule, [

                'vendor.fullname'                 => 'bail|required|string',
                'vendor.gender'                   => 'required|in:m,f',
                'vendor.contact_no'               => 'required|regex:/(353)[0-9]{9}/|digits:12',
                'vendor.address'                  => 'required|string',

            ]]);

        }

        return $rules;
    }
}
