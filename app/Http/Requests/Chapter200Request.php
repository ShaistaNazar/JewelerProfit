<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class Chapter200Request extends FormRequest
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

        if ($request->path() == '/api/get-200-price') 
        {
            $rules = [

                'major_item'          => 'required|string',
                'type'                => 'required|string',
                'no_of_items/stones'  => 'required|string',
                'karats'              => 'required|string',

            ];
        }
        return $rules;
    }
}
