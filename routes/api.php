<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Chapter300Controller;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SuperAdmin\SettingsController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StullerAPIController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Dashboard\ItemsInOurCareController;
use App\Http\Controllers\GeneralPricingController;
use App\Http\Controllers\JewelJobController;
use App\Http\Controllers\CalculationController;
use App\Http\Controllers\Chapter100Controller;
use App\Http\Controllers\Chapter200Controller;
use App\Http\Controllers\Chapter700Controller;
use App\Http\Controllers\Chapter400Controller;
use App\Http\Controllers\Chapter900Controller;
use App\Http\Controllers\Chapter500Controller;
use App\Http\Controllers\Chapter600Controller;
use App\Http\Controllers\Chapter800Controller;
use App\Http\Controllers\Chapter1100Controller;
use App\Http\Controllers\Chapter1200Controller;
use App\Http\Controllers\Chapter1300Controller;
use App\Http\Controllers\JewelerController;
use App\Http\Controllers\SaleStaffController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Chapter1000Controller;
use App\Http\Controllers\EnvelopeController;
use App\Http\Controllers\GlobalVendorsController;
use App\Http\Controllers\MasterPriceController;
use App\Models\SuperAdmin;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::get('/forgot-password', [App\Http\Controllers\AuthenticationController::class, 'sendResetLink'])->middleware('guest')->name('password.request_link');
// Route::get('/reset-password/{token}', [App\Http\Controllers\AuthenticationController::class, 'showPasswordResetForm'])->middleware('guest')->name('password.reset');

// Route::post('/reset-password', [App\Http\Controllers\AuthenticationController::class, 'resetPassword'])->middleware('guest')->name('password.change');
// Route::middleware('guest')->group(function () {

Route::post('/signup', [AuthenticationController::class, 'signup']);
Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/forgot/email', [AuthenticationController::class, 'sendResetLink']);
Route::post('/password/reset',[AuthenticationController::class, 'resetPassword']);

//social signup/login
Route::get('/login/{provider}', [App\Http\Controllers\AuthenticationController::class, 'redirect']);
Route::get('/login/{provider}/callback',[App\Http\Controllers\AuthenticationController::class, 'callback']);
Route::post('/is-user-verified',[App\Http\Controllers\AuthenticationController::class, 'isUserVerified']);
// Route::post('/password/send-verification-code', [AuthenticationController::class, 'sendVerificationCode']);
// Route::post('/password/change', [AuthenticationController::class, 'changePasswordByVerificationCode']);

// });
// dd(request());
// dd(\Auth::user());

Route::middleware(['auth.multiple:shop_owner_api,super_admin_api'])->group(function () {
    
    # generic
    Route::post('/user',  [AuthenticationController::class, 'getAuthenticatedUser']);
    Route::post('/logout', [AuthenticationController::class, 'userLogout']);
    Route::post('/personal-information', [UserController::class, 'storeOwnerPersonalInformation']);
    Route::get('/get-customers', [CustomerController::class, 'index']);
    Route::post('/add-customer', [CustomerController::class, 'store']);
    Route::post('/update-customer', [CustomerController::class, 'update']);
    Route::post('/delete-customer', [CustomerController::class, 'destroy']);
    Route::post('/get-stuller-products', [StullerAPIController::class, 'getStullerProducts']);
    Route::get('/get-stuller-product-by-SKU', [StullerAPIController::class, 'getStullerProductsBySKU']);
    Route::get('/get-chapter-flow',[ConfigController::class,'getChapterFlow']);
    Route::get('/get-jewelers-of-shop',[JewelerController::class,'index']);
    Route::get('/get-sale-staff-of-shop',[SaleStaffController::class,'index']);
    Route::get('/get-sale-person-of-shop',[SaleStaffController::class,'show']);
    Route::get('/get-outside-vendors-of-shop',[VendorController::class,'index']);
    Route::post('/add-vendor', [VendorController::class, 'store']);
    Route::post('/delete-vendor', [VendorController::class, 'destroy']);
    Route::post('/update-vendor-of-shop',[VendorController::class,'update']);
    Route::post('/estimate-the-product',[Chapter1100Controller::class,'estimateTheProduct']);
    Route::get('/get-estimated-items',[Chapter1100Controller::class,'getEstimatedItems']);
    Route::post('/update-estimate',[Chapter1100Controller::class,'updateEstimate']);
    Route::get('/get-chapter-data',[MasterPriceController::class,'getChapterData']);
    Route::post('/change-master-price-100',[MasterPriceController::class,'change100MasterPrice']);
    Route::post('/change-master-price-200',[MasterPriceController::class,'change200MasterPrice']);
    Route::post('/change-master-price-700',[MasterPriceController::class,'change700MasterPrice']);
    Route::post('/change-master-price-300',[MasterPriceController::class,'change300MasterPrice']);
    Route::post('/change-master-price-900',[MasterPriceController::class,'change900MasterPrice']);
    Route::post('/change-master-price-1000',[MasterPriceController::class,'change1000MasterPrice']);
    Route::post('/change-envelopes-location',[EnvelopeController::class,'moveEnvelopeToLocation']);
    Route::get('/get-vendors-of-shop',[GlobalVendorsController::class,'index']);
    

    # chapter 200
    Route::post('/get-100-price',[Chapter100Controller::class,'getPrice']);

    # chapter 200
    Route::post('/get-200-price',[Chapter200Controller::class,'getPrice']);
    
    # chapter 300
    Route::post('/get-300-price',[Chapter300Controller::class,'getPrice']);

    # chapter 400
    Route::post('/get-400-price',[Chapter400Controller::class,'getPrice']);

    # chapter 500
    Route::post('/get-500-price',[Chapter500Controller::class,'getPrice']);

    # chapter 600
    Route::post('/get-600-price',[Chapter600Controller::class,'getPrice']);

    # chapter 700
    Route::post('/get-700-price',[Chapter700Controller::class,'getPrice']);

    # chapter 800
    Route::post('/get-800-price',[Chapter800Controller::class,'getPrice']);

    # chapter 900
    Route::post('/get-900-price',[Chapter900Controller::class,'getPrice']);

    # chapter 1000
    Route::post('/get-1000-price',[Chapter1000Controller::class,'getPrice']);

    # chapter 1100
    Route::post('/get-1100-price',[\App\Http\Controllers\Chapter1100Controller::class,'getPrice']);

    # chapter 1200
    Route::post('/get-1200-price',[Chapter1200Controller::class,'getPrice']);

     # chapter 1300
    Route::post('/get-1300-price',[Chapter1300Controller::class,'getPrice']);

    Route::get('/get-all-clasps',[Chapter300Controller::class,'getAllClasps']);
    Route::post('/get-menu-clasp-details',[Chapter300Controller::class, 'getClaspMenuDetails']);
    Route::post('/confirm-the-job',[GeneralPricingController::class, 'confirmTheJob']);
    Route::post('/update-owner-details',[UserController::class,'updateOwnerDetails']);
    Route::get('/get-all-permissions',[ConfigController::class,'getPermissions']);
    Route::get('/get-shop',[ShopController::class,'getShop']);
    Route::post('/update-shop',[ShopController::class,'update']);
    Route::post('/create-receipt',[ReceiptController::class, 'createReceipt']);
    Route::post('/edit-customer',[CustomerController::class, 'show']);
    Route::post('/get-next-options',[GeneralPricingController::class, 'getNextOptions']);
    Route::post('/store-item-in-care',[ItemsInOurCareController::class, 'store']);
    Route::post('/add-other-amount',[CalculationController::class, 'addOtherAmount']);
    Route::get('/get-sales-tax',[GeneralPricingController::class, 'getSalesTax']);
    Route::post('/set-sales-tax',[GeneralPricingController::class, 'setSalesTax']);
    Route::get('/get-envelope-numbers',[GeneralPricingController::class, 'getEnvelopeNumbers']);
    Route::post('/favorite-the-sku',[GeneralPricingController::class, 'favoriteTheSKU']);
    Route::get('get-chapter-dependencies',[GeneralPricingController::class, 'GetLinkedChapters']);
    Route::get('get-image-requiring-chapters',[GeneralPricingController::class, 'GetImageRequiringChapters']);
    Route::get('get-chapters',[GeneralPricingController::class, 'GetJobChapters']);
    Route::get('get-chap1000metals',[Chapter1000Controller::class, 'Get1000Metals']);
    Route::post('add-envelope-details',[EnvelopeController::class,'addEnvelopeDetails']);  
    Route::get('get-sort-box',[EnvelopeController::class,'getSortBox']);
    Route::get('get-order-box',[EnvelopeController::class,'getOrderBox']);
    Route::get('get-hold-box',[EnvelopeController::class,'getHoldBox']);
    Route::get('get-finished-box',[EnvelopeController::class,'getFinishedBox']);
    Route::get('get-jeweler-box',[EnvelopeController::class, 'getJewelerBox']);
    Route::get('get-appraiser-box',[EnvelopeController::class, 'getAppraiserBox']);
    Route::get('get-cad-waxer-box',[EnvelopeController::class, 'getCadWaxerBox']);
    Route::get('get-polish-room-box',[EnvelopeController::class, 'getPolishRoom']);
    
    
    Route::namespace('Dashboard')->prefix('dashboard')->group(function () { 

        Route::get('get-items-in-care',[ItemsInOurCareController::class, 'index']);
        Route::post('get-customer-items-in-shop',[ItemsInOurCareController::class, 'getCustomerItemsInShopCare']);
        Route::delete('delete-customer-items-in-shop-care',[ItemsInOurCareController::class, 'deleteItemInOurCarePerCustomer']);
        Route::delete('delete-items-in-shop-care',[ItemsInOurCareController::class, 'deleteItemInOurCarePerShop']);
        Route::get('get-jobs-per-jeweler',[JewelJobController::class, 'jewelJobsPerJeweler']);
        Route::get('get-annual-income-of-jeweler',[JewelJobController::class, 'getAnnualIncomeOfJeweler']);
        Route::get('get-annual-income-of-shop-jewelers',[JewelJobController::class, 'getAnnualIncomeOfShopJewelers']);
        Route::get('get-annual-income-of-all-shop-jewelers',[JewelJobController::class, 'getAnnualIncomeOfAllShopJewelers']);
        Route::get('get-annual-income-of-all-shop-jewelers',[JewelJobController::class, 'getAnnualIncomeOfAllShopJewelers']);
        Route::get('get-shop-jobs-by-status',[JewelJobController::class, 'getShopJobsByStatus']);
        Route::get('get-cliq-shanks',[Chapter100Controller::class, 'getCliqShanks']);
        Route::post('update-cliq-shanks',[Chapter100Controller::class, 'updateCliqShanksCost']);
        Route::post('update-shop-shank-details',[Chapter100Controller::class, 'updateShopShankDetails']);

    });  
});
// Route::group(['middleware' => ['role:super_admin', 'permission:view_stores']], function () {
//     // Routes for shop owner dashboard
// });

Route::group(['middleware' => 'auth:super_admin_api'], function ($router) {
    Route::namespace('SuperAdmin')->prefix('admin')->group(function () { 
        Route::post('update-basic-pricing',[SettingsController::class, 'updateBasicPricing']);
        Route::post('get-basic-pricing',[SettingsController::class, 'getBasicPricing']);
        // set sales tax
        // get sales tax
    });
});


