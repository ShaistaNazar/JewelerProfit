<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthenticationRequest;
use App\Mail\SendPasswordVerificationCode;
use App\Models\ShopOwner;
use App\Models\SuperAdmin;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use DB; 
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class AuthenticationController extends Controller
{
    
	public function __construct()
	{
		
	} 

	/**
	 * signup API, handling non social signup
	 */
	public function signup(AuthenticationRequest $request)
	{

		// try{ 

			$user_details = getByValue(new ShopOwner(),['email' => $request->email]);
			$token = Str::random(64);
			session(['emailVerificationString' => $token]);
 
 			if(!$user_details){

				$user_details = ShopOwner::create($request->all());
				$user_details->assignRole(['shop_owner']);

				UserVerify::create([
					'user_id' => $user_details->id, 
					'token' => $token
				]);
				// dd('dont exist');
				Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($request){
					$message->to($request->email);
					$message->subject('Email Verification Mail');
				});

				// event(new UserRegistered($user_details));
				return $this->APIResponse(config('response_codes.Created'), 'We have sent you email to verify your account, kindly check your email to proceed furthur');

			}else{

				$user_verification_record = UserVerify::where('user_id',$user_details->id)->first();
				$user_verification_record->token = $token;
				$user_verification_record->save();
// dd(count(Mail::failures()));
				Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($request){
					$message->to($request->email);
					$message->subject('Email Verification Mail');
				});

				return $this->APIResponse(config('response_codes.Accepted'),
				'User of this email already exists, we have sent you email to verify your account, kindly check your email to proceed furthur');

			}

            
		// }catch(\Exception $e){

		// 	return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());

		// }
		
	}

	/**
	 *  verify account
	 */

	public function verifyAccount($token)
	{
		
		$message = 'Sorry your email cannot be identified.';
		$verifyUser = UserVerify::where('token', $token)->first();
		if($verifyUser){

			$user = $verifyUser->user;
			if($user->is_email_verified == null || $user->is_email_verified == false) {

				$user->is_email_verified = true;
				$user->email_verified_at = \Carbon\Carbon::now()->toDateTimeString();
				$user->save();
				$message = "Your e-mail is verified. You can now login.";

			} else {

				$message = "Your e-mail is already verified. You can now login.";

			}

			return redirect('/signin')->with('message', $message);

		}else{

			return redirect('/not-verified')->with('message', $message);

		}
	}

	/**
	 * method responsible to redirect to their social account's signup/signin page in case of social signup/signin
	 */
	public function redirect($provider)
	{
		//
		return Socialite::driver($provider)->redirect();

	}

	/**
	 * method handling call back to the application in case of successful social signup/login 
	 */
	public function callback($provider)
	{
		try{
			
			$user = Socialite::driver($provider)->user();
			$user_exists = ShopOwner::updateOrCreate(
				['email' => $user->getEmail()],
				[
					'username'                 => $user->getName(),
					'fullname'                 => $user->getName(),
					'email'                    => $user->getEmail(),
					'image'                    => $user->getAvatar(),
					'provider_id'              => $user->getId(),
					'provider'                 => $provider,
	 				'social_access_token'      => $user->token,
					'login_type'               => 'social',
					'is_active'                => true,
					'password'                 => null,
					'is_email_verified'        => true,
					'email_verified_at'        => \Carbon\Carbon::now()->toDateTimeString(),
				]
			);
			auth('web')->login($user,true);
			// Auth::login($user_exists,true);
			$user_token = $user_exists->createToken($user_exists->fullname)->accessToken;
			session(['abc' => $user_token]);

			return redirect('/');

		}catch(\Exception $e){

			return redirect('/signin');
			
		}
		
	}

	
    /**
	 * get authenticated user
	 */
	public function getAuthenticatedUser()
	{
		return auth(getGuard())->user()->load(['permissions', 'roles']);
	}


	/**
	 * API responsible to login the user and generate token
	 */
	public function login(AuthenticationRequest $request)
	{

		$credentials = $request->only('email', 'password');
		// dd(SuperAdmin::all());
		// dd(strtolower($credentials['email']) == strtolower(config('gellerbook.geller_email')));
		if(strtolower($credentials['email']) == strtolower(config('gellerbook.geller_email'))) {
			$guard = 'super_admin_api';
			$user_details = getByValue(new SuperAdmin(),['email' => $credentials['email']]);
		} else {
			$guard = 'shop_owner_api';
			$user_details = getByValue(new ShopOwner(),['email' => $credentials['email']]);
		}

		if ($user_details) {

			// $user_details = SuperAdmin::find(13);
			// Auth::guard('web')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']], true);
			$user_details->token = $user_details->createToken($user_details->fullname)->plainTextToken;
			// dd($user_details);
			// dd(\Spatie\Permission\Models\Role::all());
			if($guard == 'super_admin_api') 
			{
				// Auth::guard('super_admin_api')->login($user_details);
				// auth('super_admin_api')->login($user_details,true);
				$role = \Spatie\Permission\Models\Role::where('name' , 'super_admin')->first();
				// dd($role);
				// Assign the role to the user
				$user_details->assignRole($role);
				// $user_details->assignRole('super_admin');
			} else if($guard == 'shop_owner_api') {
				// auth()->login($user_details,true);
				$user_details->assignRole('shop_owner');
			}
			$roles = $user_details->roles;
			foreach ($roles as $role) {
				$user_details->syncPermissions($role->permissions);
			}
			return $this->APIResponse(config('response_codes.OK'), 'login successful', $user_details);
			} else {
				return $this->APIResponse(config('response_codes.Bad Request'), 'Email or password is incorrect');
			}
		// }catch(\Exception $e){
			
		// 	return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());

		// }
	}

	/**
	 * API responsible to login the user and generate token
	 */
	public function resendAccountVerificationEmail(AuthenticationRequest $request)
	{
		//email
		try{

			$user_details = getByValue(new ShopOwner(),['email' => $request->email]);
			$token = Str::random(64);
			session(['emailVerificationString' => $token]);
			$user_verification = UserVerify::where('user_id',$user_details->id)->first();

            if($user_verification){
				$user_verification->token =  $token;
                $user_verification->save();
			}else{
				$user_verification = UserVerify::create([
					'user_id' => $user_details->id, 
					'token' => $token
				]);
			}

			Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($request){
				$message->to($request->email);
				$message->subject('Email Verification Mail');
			});

			return $this->APIResponse(config('response_codes.Created'), 'email resent successfully');

		}catch(\Exception $e){
			
			return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());

		}
	}

	/**
	 * user logout
	 */
	public function userLogout(AuthenticationRequest $request)
	{
		try{
			if (Auth::check()) 
			{
				$user_tokens = Auth::user()->tokens;
				if($user_tokens)
				// Auth::user()->currentAccessToken()->delete();
				Auth::user()->tokens()->delete();
				session(['token'=> null]);
				return $this->APIResponse(config('response_codes.OK'), 'logout successfully');
			}
		}catch(\Exception $e){

			return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());

		}
	}

	/**
	* API handling sending resetting link
	*/

    public function sendResetLink(AuthenticationRequest $request)
	{
		try{
			// email
			
			$user_details = getByValue(new ShopOwner(),['email' => $request->email]);
            
			if($user_details){

			$token = Str::random(64);
			DB::table('password_resets')->insert([
				'email' => $request->email, 
				'token' => $token, 
				'created_at' => Carbon::now()
			]);
			$failed_emails = count(Mail::failures());
			Mail::send('emails.passwordResetLink', ['token' => $token], function($message) use($request){

				$message->to($request->email);
				$message->subject('Reset Password');

		    });

              if(count(Mail::failures()) > $failed_emails){

				return $this->APIResponse(config('response_codes.Not Implemented'), 'Error in sending Password Reset Link.');

			}else{

				return $this->APIResponse(config('response_codes.OK'), 'Password Reset Link sent on your email.');

			}

			}else{

				return  $this->APIResponse(config('response_codes.Not Found'), 'User does not exists.');

			}

		}catch(\Exception $e){

    		return  $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }		
		
	}

	/**
	 * API to reset Password
	 */
	public function resetPassword(Request $request)
	{
    try{
		$user = getByValue(new ShopOwner(),['email' => $request->email]);

		if($user){

			$updatePassword = DB::table('password_resets')->where([
			  'email' => $request->email, 
			  'token' => $request->token
			])->first();

			if(!$updatePassword){

			    return $this->APIResponse(config('response_codes.Bad Request'), 'Invalid Token.');

			}

			$user->password = $request->password;
			$user->save();

			return $this->APIResponse(config('response_codes.OK'), 'password has been reset successfully.',$user);

		}else{
			
			return $this->APIResponse(config('response_codes.Bad Request'), 'User does not exists.');

		}

		//email,token,password
		
		}catch(\Exception $e){

		return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
    }

  }


	/**
	* API handling sending resetting link
	*/

    public function sendVerificationCode(AuthenticationRequest $request)
	{
		try{
			// email
			$user = ShopOwner::getByEmail($request->email);
			Mail::to('shaistanazar4@gmail.com')->send(new SendPasswordVerificationCode($user));

			return $this->APIResponse(config('response_codes.OK'), 'password verification code has been sent successfully.');

		}catch(\Exception $e){

			return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
        }		
		
	}

	// public function showPasswordResetForm(AuthenticationRequest $request)
	// {

	// 	return view('auth.reset', ['token' => $request->token]);
	
	// }


	/**
	 * change password API by verifying  
	 */
	public function changePasswordByVerificationCode(AuthenticationRequest $request)
	{
    try{

		//email,code,password
		$user_details = ShopOwner::getByEmail($request->email);
		if($request->code == $user_details->verification_code){
		$user_details->verification_code = null;
		$user_details->password = $request->password;
		$user_details->save();
		event(new PasswordReset($user_details));
		return $this->APIResponse(config('response_codes.OK'), 'password has been reset successfully.');

		}else{
			return $this->APIResponse(config('response_codes.Bad Request'), 'entered code does not match with verification code');
		}

		}catch(\Exception $e){
		return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
    }

  }
/**
 * function to depict that is user verified or not
 */
  public function isUserVerified(AuthenticationRequest $request)
  {
	
	$user_details = getByValue(new ShopOwner(),['email' => $request->only('email')]);
	if($user_details){

        if($user_details->is_email_verified){

			return $this->APIResponse(config('response_codes.OK'), 'user is verified.',true);

		}else{

			return $this->APIResponse(config('response_codes.Bad Request'), 'user is not verified.');

		}

	}else{

		return $this->APIResponse(config('response_codes.Bad Request'), 'User does not exists.');

	}
  }

}