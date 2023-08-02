<?php

namespace App\Http\Controllers;

use App\Models\GlobalVendor;
use Illuminate\Http\Request;

class GlobalVendorsController extends Controller
{
    public function index(Request $request)
    {
        try{
         
            $global_vendors = shop()->global_vendors()->paginate(4);
            // dd($global_vendors);
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned all vendors of shop.', $global_vendors );
           
        }catch(\Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }
    }
}
