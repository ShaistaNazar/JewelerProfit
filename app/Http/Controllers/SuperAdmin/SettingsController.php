<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsRequest;
use App\Models\Setting;
use Exception;

class SettingsController extends Controller
{
    /**
     * update Settings
     */

    public function updateSettings(SettingsRequest $request)
    {
        try{

            $setting = Setting::where('setting',$request->settings_name)->first();
            $setting->value = $request->settings_value;
            $setting->save();

            return $this->APIResponse(config('response_codes.OK'), 'Settings updated successfully.', $setting);

        }catch(Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }

    }

    /**
     * get Settings
     */
    public function getBasicPricing(SettingsRequest $request)
    {
        try{

            $setting = Setting::where('setting',$request->settings_name)->first();
            return $this->APIResponse(config('response_codes.OK'), 'Basic pricing returned sucessfully', $setting);

        }catch(Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }
    }

}
