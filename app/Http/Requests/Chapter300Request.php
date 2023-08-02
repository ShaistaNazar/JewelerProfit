<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class Chapter300Request extends FormRequest
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
        // if ($request->path() == '/api/get-menu-clasp-details') 
        // {
        //     $rules = [
        //         'title'   => 'required|string',
        //     ];
        // }
        if ($request->path() == '/api/get-300-price') 
        {
            $rules = [

                'major_item'   => 'required|string',
                'menu'         => 'required|string',
                'size'         => 'required|string',
                'karat'        => 'required|string',
                'color'        => 'required|string',
                'picklist'     => 'required|string',


            ];
        }
        return $rules;
    }
}
