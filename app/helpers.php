<?php

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
 
  function processAPI($rescode , $message = null , $values = null)
  {

  }
  
  /**
   * get any record as per any model
   */
  function getByValue($model, $conditions)
  {

    $object = $model->where($conditions)->first();
    return $object;

  }

  /**
   * get collection of records as per any model by some conditions
   */
  function getCollectionByValue($model, $conditions)
  {

    $collection = $model->where($conditions)->get();
    return $collection;

  }

  /**
   * bind job to jeweler
   */
  function populateModel($model, $values)
  {
    $created_object = $model::create($values);
    return $created_object;
  }

  /**
   * bind job to jeweler
   */
  function shop()
  {
    // dd(auth(getGuard())->user(),getGuard());
    
    return auth(getGuard())->user()->shop->load('shopOwner');
  }

  function getDavidChapter($chapter)
  {
    $class_name = '\App\Models\DavidPricing\Chapter'.$chapter;
    $model_class = get_class(new $class_name ());
    return $model_class;
  }

  function getGuard()
  {
    // dd(request()->guard);
    // return 'super_admin_api';


   
    if(auth()->guard('shop_owner_api')->check())
    {
      return 'shop_owner_api';
    }
    else
    {
      return 'super_admin_api';
    }
// return 'super_admin_api';
// dd(auth()->guard('shop_owner_api')->check());
      // return $guard;
  }
  function getModelByChapter($chapter)
  {
    $class_name = '\App\Models\DavidPricing\Chapter'.$chapter;
    $model_class = get_class(new $class_name ());
    return $model_class;
  }

  function salesTax()
  {
    $sales_tax = Setting::where('setting','sales_tax')->first()->value;
    return $sales_tax;
  }

    
  function fractionToDecimal($fraction) 
  {
    // Split fraction into whole number and fraction components
    preg_match('/^(?P<whole>\d+)?\s?((?P<numerator>\d+)\/(?P<denominator>\d+))?$/', $fraction, $components);
    // Extract whole number, numerator, and denominator components
    $whole = $components['whole'] ?: 0;
    $numerator = $components['numerator'] ?: 0;
    $denominator = $components['denominator'] ?: 0;
    
    // Create decimal value
    $decimal = $whole;
    $numerator && $denominator && $decimal += ($numerator/$denominator);
    
    return $decimal;
  }

 


