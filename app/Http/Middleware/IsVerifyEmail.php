<?php
  
namespace App\Http\Middleware;
  
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class IsVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->expectsJson()) {

            if(isset($request->email)){

                $user_details = getByValue(new ShopOwner(),['email' => $request->only('email')]);
    
                if(!($user_details && $user_details->is_email_verified)){
        
                    return redirect('/signup');
        
                }else{

                    return $next($request);

                }
    
            }
            return redirect('/signup');
            // return $next($request);

        }else{
            
            if(isset($request->email)){

                $user_details = getByValue(new ShopOwner(),['email' => $request->only('email')]);
    
                if(!($user_details && $user_details->is_email_verified)){
        
                    return response([
                        "status" => 0,
                        "message" => 'sorry your email is not verified, please signup first or request another',
                        "data" => [],
                        "error" => "you are not authorized to access this data"
                    ], 401);
        
                }else{

                    return $next($request);

                }
    
            }
            return response([
                "status" => 0,
                "message" => 'sorry your email is not verified, please signup first or request another',
                "data" => [],
                "error" => "you are not authorized to access this data"
            ], 401);

        }

    }
}