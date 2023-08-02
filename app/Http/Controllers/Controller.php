<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

/**
 * function responsible to give json response of APIs
 */

function APIResponse($rescode , $message = null , $values = null)
  {
    if(!$values){
      $values = new \stdClass();
    }
    $message=ucfirst($message);
    return response()->json([
      'response_header' => [
        'response_code' => $rescode,
        'response_message' =>  $message
        ],
        
        'data' => $values
        
      ], $rescode);
  }
}
