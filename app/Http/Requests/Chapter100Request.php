<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Chapter100Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return Auth::id() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules(Request $request)
    {
        $rules = [];

		if ($request->path() == 'api/get-sizing-price') 
		{
			$rules = [

				'no_of_envelopes'                 => 'required|numeric',
				'duplicate_same_customer_on_each' => 'required_if:no_of_envelopes,>=,2|nullable|boolean',
				'rush_job'                        => 'required|boolean',
                'technology'                      => 'required|in:laser,torch',
				'karat'                           => 'required|in:14,18,platinum,silver',
				'sizing_category'                 => 'required|in:regular_ring,class_ring,plain_band,wedding_band',
                'color'                           => 'required|in:y,g',
                'size_new'                        => 'required|in:smaller,larger',
				'width'                           => 'required|in:<3mm,3mm-5mm,5mm-8mm',
				'no_of_stones'                    => 'required|in:0-4,5-20,21-35,36-50,>50',
				'size_now'                        => 'required|in:5,5 1/4,5 1/2,5 3/4,6,6 1/2,7,7 1/2,8,8 1/2,9,9 1/2,10,10 1/2,11,11 1/2,12,12 1/2,13,13 1/2,14,14 1/2,15',
                'size_to'                         => 'required|in:5,5 1/4,5 1/2,5 3/4,6,6 1/2,7,7 1/2,8,8 1/2,9,9 1/2,10,10 1/2,11,11 1/2,12,12 1/2,13,13 1/2,14,14 1/2,15'

			];
		}

        return $rules;
        
    }
}
