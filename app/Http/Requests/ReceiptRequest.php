<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class ReceiptRequest extends FormRequest
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

     # paid
     // Paid By Visa Card
     // payment data 10/31/2021 5:45pm
     // Picked Up By: (customer) Harry Smith

    if ($request->path() == 'api/create-repair-receipt'){
        $rules= [

            'jeweler_id'        => 'required|numeric',
            'receipt_type'      => 'required|string',
            'customer_no'       => 'required|string',
            'envelope_no'       => 'required|string',
            'job_history_ids'   => 'required|array',
            'grand_total'       => 'required|string',
            'payment_method'    => 'required_if:receipt_type,==,paid|string',
            'picked_by'         => 'required_if:receipt_type,==,paid|string',
            'assisted_by'       => 'required_if:receipt_type,==,paid|string',

        ];
    }
    return $rules;
    }
}
