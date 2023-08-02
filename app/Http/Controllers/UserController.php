<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Filters\UserFilters;
use App\Models\DavidPricing\Chapter100;
use App\Models\GlobalVendor;
use App\Models\ShopOwner;
use App\Models\ShopShankDetails;
use App\Models\SuperAdmin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use DB;

class UserController extends Controller
{
   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getShopOwners(UserFilters $filters)
    {
        try{

            $shop_owners = ShopOwner::filter($filters)->paginate(10);
            return $this->APIResponse(config('response_codes.OK'), null, $shop_owners);

        }catch(\Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOwnerPersonalInformation(UserRequest $request)
    {
        DB::beginTransaction();
        $url = '';
        // dd(gettype($request->have_laser));
        // try {
            if(json_decode( $request->owner_email, true) == 'shaistanazar@technerdslab.com')
            {
                $owner = SuperAdmin::updateOrCreate(
                    ['email' => json_decode( $request->owner_email, true)],
                    [
                        'fullname'   => json_decode( $request->owner_fullname, true),
                        'contact_no' => json_decode( $request->owner_contact, true),
                        'address'    => json_decode( $request->owner_address, true),
                    ]
                );
            }
            else
            {
                $owner = ShopOwner::updateOrCreate(
                    ['email' => json_decode( $request->owner_email, true)],
                    [
                        'fullname'   => json_decode( $request->owner_fullname, true),
                        'contact_no' => json_decode( $request->owner_contact, true),
                        'address'    => json_decode( $request->owner_address, true),
                    ]
                );
            }
            
            /** handling images */

            if ($request->hasFile('image')) 
            {
                //  Let's do image handling here

                if ($request->file('image')->isValid()) {
                    
                    $extension = $request->image->extension();
                    
                    $url = Storage::putFileAs(
                        'shop_trademarks', $request->image, json_decode($request->owner_shop_name, true).".".$extension
                    );
                }
            }
            
            $shop = Shop::where(['owner_id'=>$owner->id]);
            // dd($shop->get());
            if(count($shop->get()) == 1)
            {
                $shop = $shop->first();
                $shop_updated = $shop->update([

                    'shop_name'                    => json_decode($request->owner_shop_name, true),
                    'street_address'               => json_decode($request->owner_shop_street_address, true),
                    'zip_code'                     => json_decode($request->owner_shop_zip, true),
                    'apartment'                    => json_decode($request->owner_shop_apartment, true),
                    'contact_no'                   => json_decode($request->owner_shop_contact_no, true),
                    'city'                         => json_decode($request->owner_shop_city, true),
                    'trademark_url'                => $url,
                    'have_laser'                   => str_contains('yes',$request->have_laser) ? true : false,
                    
                ]);
              }
            else
            {
                $shop = Shop::create([

                    'shop_name'                    => json_decode($request->owner_shop_name, true),
                    'street_address'               => json_decode($request->owner_shop_street_address, true),
                    'zip_code'                     => json_decode($request->owner_shop_zip, true),
                    'apartment'                    => json_decode($request->owner_shop_apartment, true),
                    'contact_no'                   => json_decode($request->owner_shop_contact_no, true), 
                    'city'                         => json_decode($request->owner_shop_city, true),
                    'owner_id'                     => $owner->id,
                    'trademark_url'                => $url,
                    'have_laser'                   => str_contains('yes',$request->have_laser) ? true : false,

                ]);
            }

            // dd($shop);
            $cliq_shank_exists = Chapter100::whereRaw('LOWER(`type`) LIKE ? ',[trim(strtolower('cliq-adjustable')).'%'])->first();
            // dd($cliq_shank_exists);
            $latest = null;
            $vendor_markup = null;
            if($cliq_shank_exists)
            {
                $vendor_markup = $cliq_shank_exists->vendor_markup_for_part_geller_book_retail;
                $latest = $cliq_shank_exists->updated_at;
            }
            if(!(ShopShankDetails::whereNotNull('vendor_cost_markup')->first()))
            {
                ShopShankDetails::create([
                    'latest_pricing_date'         =>  $latest,
                    'vendor_cost_markup'          =>  $vendor_markup,
                    'is_default'                  =>  1,
                    'latest_pricing_date'         =>  Carbon::now()->toDateTimeString()
                ]);
            }

            $global_vendor = GlobalVendor::updateOrCreate(
				['link' => 'stuller.com'],
				[
					'name'       => $request->owner_fullname,
                    'shop_id'    => $request->owner_contact,
				]
			);

            $staff_array = [];
            $jeweler_array = [];
            
            foreach(json_decode($request->input('sale_staff'), true) as $key=>$value) {

                $staff_array[$key] = array_merge($value,[

                    'shop_id' => $shop->id,
                    'type' => 'sale_staff'
                    
                ]);

            }

            foreach(json_decode($request->input('jeweler'), true) as $key=>$value) 
            {
                if($value['fullname'] && $value['fullname'] !== '')
                {
                    $jeweler_array[$key] = array_merge($value,[
                        'shop_id' => $shop->id,
                        'type' => 'jeweler'
                    ]);
                }
            }

            $tables = [ 'chapter100pricing','chapter200pricing','chapter300pricing',
                        'chapter400pricing','chapter500pricing','chapter600pricing',
                        'chapter700pricing','chapter800pricing','chapter900pricing',
                        'chapter1000pricing','chapter1100pricing','chapter1200pricing',
                        'chapter1300pricing'];

            $new_shop_id = $shop->id; 
            $currentTime = Carbon::now()->toDateTimeString();

            // foreach ($tables as $table) {
                
            //     // $prefix = "Chapter";
            //     preg_match('/\d+(?!\d)/', $table, $matches); // Find one or more digits not followed by a digit
            //     $number = $matches[0]; // Extract the first match
            //     // $result = $prefix . strtoupper($number); // Combine the prefix and the uppercase number
            //     // $model = 'App\\Models\\' . $result;
                
            //     $model_class = getModelByChapter($number);
            //     if(!($model_class::where('shop_id',$new_shop_id)->first()))
            //     {
            //         $model_class::where('is_david',true)
            //         ->orderBy('id')
            //         ->chunk(100, function ($existingRows) use ($new_shop_id, $currentTime) {
            //             foreach ($existingRows as $existingRow) {
            //             // dd($existingRow);
            //                 $newRow = $existingRow->replicate();
            //                 $newRow->shop_id = $new_shop_id;
            //                 $newRow->created_at = $currentTime;
            //                 $newRow->updated_at = $currentTime;
            //                 $newRow->is_david = false;
            //                 $newRow->save();
            //             }
            //         });
            //     }
            //     }
// }
// In this code, we're using the Eloquent model associated with each table
// to retrieve the existing rows ($existingRows) with where('shop_id', 1)->orderBy('id')->get(). 
//We then iterate through each row and replicate it using the replicate() method, update the shop_id, 
//created_at, updated_at, and is_david attributes, and save the new row using the save() method.

// I hope this helps! Let me know if you have any other questions.
            
            User::insert($staff_array);
            User::insert($jeweler_array);

            // all good
            DB::commit();

			return $this->APIResponse(config('response_codes.OK'), 'Owner details filled up successfully.',$shop);

    //     } catch (\Exception $e) {

    //         DB::rollback();
    //         // Get the stack trace (limit to 10 levels)
    // $trace = $e->getTraceAsString();
    // // Print the stack trace
    // echo $trace;
    //                 echo "---";
	// 		return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

    //     }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOwnerDetails(Request $request)
    {
        DB::beginTransaction();

        try {
            $url = '';
            $owner = ShopOwner::updateOrCreate(
				['email' => $request->owner_email],
				[
					'fullname'   => $request->owner_fullname,
                    'contact_no' => $request->owner_contact,
                    'address'    => $request->owner_address,
				]
			);
            /** handling images */
            
            // Storage::delete($owner->shop->trademark_url);

            if ($request->hasFile('image')) {
                //  Let's do everything here
                if ($request->file('image')->isValid()) {
                    
                    Storage::delete($owner->shop->trademark_url);
     
                    $extension = $request->image->extension();
                    $url = Storage::putFileAs(
                        'shop_trademarks', $request->image, $request->owner_shop_name.".".$extension
                    );

                }
            }

            $owner = Shop::updateOrCreate(
				['owner_id'  => $owner->id,],
				[
					'shop_name' => $request->owner_shop_name,
                    'trademark_url'  => $url
				]
			);

            /** end of images handling */

            $staff_array = [];
            $jeweler_array = [];
            
            // dd($owner->jewelers);
            // $school->programs()->createMany(
            //     collect($request->day)->map(function($day, $key) {
            //         return [
            //             'day' => $day,
            //             'schedule' => request('schedule')[$key],
            //         ];
            //    })->toArray()
            // );

            foreach($request->input('sale_staff.*') as $key=>$value) {

                $staff_array[$key] = array_merge($value,[
                    'shop_id' => $shop->id,
                ]);

            }

            foreach($request->input('jeweler.*') as $key=>$value) {

                $jeweler_array[$key] = array_merge($value,[
                    'shop_id' => $shop->id,
                ]);

            }
            
            User::insert($staff_array);
            User::insert($jeweler_array);

            // all good
            DB::commit();

			return $this->APIResponse(config('response_codes.OK'), 'Owner details filled up successfully.');

        } catch (\Exception $e) {

            // DB::rollback();
			return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }
    }
}
