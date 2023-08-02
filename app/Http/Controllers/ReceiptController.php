<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReceiptRequest;
use App\Models\Customer;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ReceiptController extends Controller
{

    public function createReceipt(ReceiptRequest $request)
    {

     # The receipt is printed two UP on 8.5x11” paper, 
     # perforated paper, pop apart, customer gets a 5 1/2 x 8 1/2 copy 
     # as well as the store gets the same copy
     # Camera used to take pictures of jewelry received:
     # This is after we do our pricing and 
     # we’d print a receipt like this. 
     # the other goes inside a clear hard plastic envelope that has the jewelry in it and 
     # handed to the jeweler to do the work.
     //  jeweler name -> jeweler id   ==f
     //  receipt type  ==f
     // address of client -> config  ==b
     // website link of jewelerprofit  ==b
     // envelope id   ==f
     // 10/31/2021 2:32PM   ==b
     // Customer: #1-98790   
     // cus name    ==b
     // Harry Smith 
     // 123 Main Street Apt203 Atlanta GA 30342 H: 404-856-7452    ==b
     // Cell: 770-874-2145   ==b
     // H.Smith@Gmail.com  ==b
     // jeweler name   ==b
     // desription of item   ==f
     // job name  ==f i.e., repairing or diamonds etc.
     // chapter name  ==f i.e., claps
     // item name  ==f i.e., barrel clasp
     // whather includes picklist or not
     // Sales tax  ==b
     // total 
     # paid
     // Paid By Visa Card
     // payment data 10/31/2021 5:45pm
     // Picked Up By: (customer) Harry Smith

    $receipt = Receipt::create($request->all());
    
     
    }

    public function sendReceiptToCustomer(ReceiptRequest $request)
    {
        # send receipt to customer 
        $customer = Customer::where('customer_id',$request->customer_id)->first();
        if($customer)
        {

        $email = $customer->email;
        Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($email){
            $message->to($email); 
            $message->subject('Email Verification Mail');
        });
        Mail::to($mail)->send(new TestMail);
        }else{
            return $this->APIResponse(config('response_codes.Created'), 'We have sent you email to verify your account, kindly check your email to proceed furthur');
        }
        
        // event(new UserRegistered($user_details));
        return $this->APIResponse(config('response_codes.Created'), 'We have sent you email to verify your account, kindly check your email to proceed furthur');
    }

}
