<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class SettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    
    public function authorize()
    {
        return auth('super_admin_api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [];
        if($request->path() == 'api/admin/update-settings')
        {
            $rules = [

                'setting_name'          => 'required|string',
                'setting_value'         => 'required|string',

            ];

        }

        return $rules;

    }
}
