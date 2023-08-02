<?php

namespace App\Http\HelperClasses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StullerAPIControllerHelper
{
    public $base_url;

    public function __construct(){

        $this->base_url = "https://api.stuller.com/v2/products";

    }

    public function getStullerProducts($request)
    {

       $data = array(
        "Include" => [
            4
        ],
        "Filter" => [
            0,
            2
        ],
        "CategoryIds" => [
            22077,
            22529,
            6468,
            6671,
            105,
            1944,
            106,
            18904,
            14574,
            13486,
            14547,
            13522,
            3089,
            13517
            ]
        );


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
             'Accept' => 'application/json'
        ])
        ->withBasicAuth( config('stuller.basic_auth_username'), config('stuller.basic_auth_password'))
        ->post($this->base_url, $data)->json();
     
        return array(config('response_codes.OK'),'stuller products with specific categories accessed',$response);
    }

    /**
     * get Stuller products by SKU
     */

     public function getStullerProductsBySKU($SKU)
     {
        $request = request();
        $response =  Http::withHeaders([
            'Content-Type' => 'application/json',
             'Accept' => 'application/json'
        ])->withBasicAuth( config('stuller.basic_auth_username'), config('stuller.basic_auth_password'))
        ->get($this->base_url,[
            'SKU'=>$SKU
        ])->json();
        return array(config('response_codes.OK'),'stuller product with specific SKU accessed',$response);

     }


    /**
     * function responsible to invoke every function related to stuller APIs
     */
    public function executeFunction($method,$SKU)
    {
        try{

            return $this->$method($SKU);

        }catch(\Exception $e){

            return array(config('response_codes.Internal Server Error'),$e->getMessage(),null);

        }
    }

}
