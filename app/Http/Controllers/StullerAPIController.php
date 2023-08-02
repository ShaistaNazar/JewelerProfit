<?php

namespace App\Http\Controllers;

use App\Http\HelperClasses\StullerAPIControllerHelper;
use Illuminate\Http\Request;

class StullerAPIController extends Controller
{
    public $helper;

    public function __construct(StullerAPIControllerHelper $helper){

        $this->helper = $helper;

    }

    /**
     * API to get products by SKU
     */
    
    public function getStullerProducts(Request $request)
    {
        $response_object = $this->helper->executeFunction('getStullerProducts',$request);    
        return $this->APIResponse($response_object[0], $response_object[1], $response_object[2]);
    }

    /**
     * API to get products by SKU
     */

    public function getStullerProductsBySKU($stuller)
    {
        $response_object = $this->helper->executeFunction('getStullerProductsBySKU',$stuller);    
        return $this->APIResponse($response_object[0], $response_object[1], $response_object[2]);
    }

}
