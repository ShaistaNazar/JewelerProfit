<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequest;
use App\Models\ShopOwner;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class ConfigController extends Controller
{
    public function getPermissions() 
    {
        try{
            # code...
            $data = [];
            $user = auth(getGuard())->user();
            $permissions = $user->getPermissionsViaRoles();

            $count = count($permissions);

            if( $count > 0 )
            {
                for( $i = 0; $i < $count; $i++ )
                {
                    $permission = $permissions[$i];
                    if($permission->name)
                    {

                        $explodedSlug = explode('_', $permission->name);
                        if( $explodedSlug && count($explodedSlug) > 0)
                        {
                            $data[$explodedSlug[1] . 'Menu'] = true;
                            $data[$this->underScoreToCamelCase($permission->name)] = true;

                        }

                    }
                }
            }

            return $this->APIResponse(config('response_codes.OK'), 'successfully returned user Permissions.', $data);

        }catch(Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());
        
        }
    }

     /**
     * Convert permission from dot style to camel case.
     *
     * @param string $string
     * @param bool $capitalizeFirstCharacter
     *
     * @return string $str
     */
    protected function underScoreToCamelCase($string, $capitalizeFirstCharacter = false)
    {
        $str = str_replace('_', '', ucwords($string, '_'));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }

    /**
     * get chapter vise flow
     */
    public function getChapterFlow(ConfigRequest $request)
    {
        # code ... 
        try{

            $chapter_flow = (config("flow.$request->chapter"));
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned chapter flow.', $chapter_flow);

        }catch(Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
            
        }
    }

    /**
     * Get next screen to select option from.
     */

    public function getNextScreen(ConfigRequest $request)
    {
        # code...
        $chapter_flow = (config("flow.$request->chapter"));
        $key = array_search ($request->current_screen, $chapter_flow);
        if(array_key_exists($key+1,$chapter_flow))
        {
            return $chapter_flow[$key+1];
        }
    }

}
