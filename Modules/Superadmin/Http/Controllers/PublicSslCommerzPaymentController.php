<?php

namespace Modules\Superadmin\Http\Controllers;

use Modules\Superadmin\Entities\Subscription;
use Modules\Superadmin\Entities\Package;
use App\System;
use App\Business;
use App\BusinessLocation;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Superadmin\Notifications\SubscriptionOfflinePaymentActivationConfirmation;

use \Notification;
use App\Utils\ModuleUtil;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Razorpay\Api\Api;

use Srmklive\PayPal\Services\ExpressCheckout;
use Yajra\DataTables\Facades\DataTables;

use Pesapal;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Routing\UrlGenerator;
use App\User;
session_start();

class PublicSslCommerzPaymentController extends BaseController
{

    public function index(Request $request,$package_id) 
    {

        if (config('app.env') == 'demo') {
            $output = ['success' => 0,
                            'msg' => 'Feature disabled in demo!!'
                        ];
            return back()->with('status', $output);
        }

        // Get the cart data or package details.
        $package = Package::active()->find($package_id);

        // Add the user data
        /*
        $data['items'] = [
                [
                    'name' => $package->name,
                    'price' => (float)$package->price,
                    'qty' => 1
                ]
            ];
        $data['invoice_id'] = str_random(5);
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        */

            # Here you have to receive all the order data to initate the payment.
            # Lets your oder trnsaction informations are saving in a table called "orders"
            # In orders table order uniq identity is "order_id","order_status" field contain status of the transaction, "grand_total" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

            $post_data = array();
            $post_data['total_amount'] = (float)$package->price; # You cant not pay less than 10
            $currency = json_decode(System::getCurrency(),true);
            
            $_SESSION["tran_id_currency"] = $currency['code'];
            $_SESSION["tran_id_amount"] = $post_data['total_amount'];
            
            $post_data['currency'] = $_SESSION["tran_id_currency"];
            $date = date('Y-m-d');
            $post_data['tran_id'] = 'HIS'.rand(1111,9999).'-'.$date; // tran_id must be unique

            #Start to save these value  in session to pick in success page.
            //Session::push('tran_id',$post_data['tran_id']);
            
            
            $_SESSION["tran_id"] = $post_data['tran_id'];
            #End to save these value  in session to pick in success page.


            $server_name=$request->root()."/";
            $post_data['success_url'] = $server_name . "payWithSSl/success";
            $post_data['fail_url'] = $server_name . "payWithSSl/fail";
            $post_data['cancel_url'] = $server_name . "payWithSSl/cancel";

            $business_id = request()->session()->get('user.business_id');
            $business_details = BusinessLocation::where('business_id',$business_id)->first();
            $package = Package::active()->find($package_id);            
            $user = user::find(request()->session()->get('user.id'));
            
            /* Add Data into Database */           
            

            # CUSTOMER INFORMATION
            $post_data['cus_name'] =    $user->surname.' '.$user->first_name.' '.$user->last_name;
            $post_data['cus_email'] =   $user->email;
            $post_data['cus_add1'] =    $user->address;
            $post_data['cus_add2'] =    "";
            $post_data['cus_city'] =    $business_details->city;
            $post_data['cus_state'] =   $business_details->state;
            $post_data['cus_postcode'] = $business_details->zip_code;
            $post_data['cus_country'] = $business_details->country;
            $post_data['cus_phone'] = $business_details->mobile;
            $post_data['cus_fax'] = "";

            # SHIPMENT INFORMATION
            $post_data['ship_name'] = $user->surname.' '.$user->first_name.' '.$user->last_name;
            $post_data['ship_add1 '] = $user->address;
            $post_data['ship_add2'] = "";
            $post_data['ship_city'] =  $business_details->city;
            $post_data['ship_state'] = $business_details->state;
            $post_data['ship_postcode'] = $business_details->zip_code;
            $post_data['ship_country'] = $business_details->country;

            # OPTIONAL PARAMETERS
            /*
            $post_data['value_a'] = "ref001";
            $post_data['value_b'] = "ref002";
            $post_data['value_c'] = "ref003";
            $post_data['value_d'] = "ref004";

            */
            
            $this->Subcription($business_id, $package, 'SSL Commerz', $post_data['tran_id'],'waiting', $user->id);
            /*
            Here Have to add payment Info
            #Before  going to initiate the payment order status need to update as Pending.
            $update_product = DB::table('orders')
                                    ->where('order_id', $post_data['tran_id'])
                                    ->update(['order_status' => 'Pending','currency' => $post_data['currency']]);
            */

            $sslc = new SSLCommerz();
            # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
            $payment_options = $sslc->initiate($post_data, false);

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
            }

    }
    
    protected function Subcription($business_id, $package, $gateway, $payment_transaction_id,$status, $user_id, $is_superadmin = false) {
        $subscription = ['business_id' => $business_id,
                        'package_id' => $package->id,
                        'paid_via' => $gateway,
                        'payment_transaction_id' => $payment_transaction_id
                    ];

        
            $dates = $this->get_package_dates($business_id, $package);

            $subscription['start_date'] = $dates['start'];
            $subscription['end_date'] = $dates['end'];
            $subscription['trial_end_date'] = $dates['trial'];
            $subscription['status'] = $status;//approved
        

        $subscription['package_price'] = $package->price;
        $subscription['package_details'] = [
                'location_count' => $package->location_count, 
                'user_count' => $package->user_count, 
                'product_count' => $package->product_count, 
                'invoice_count' => $package->invoice_count,
                'name' => $package->name
            ];
        //Custom permissions.
        if(!empty($package->custom_permissions)){
            foreach ($package->custom_permissions as $name => $value) {
                $subscription['package_details'][$name] = $value;
            }
        }
        
        $subscription['created_id'] = $user_id;
        Subscription::create($subscription);
    }
    
    protected function get_package_dates($business_id, $package){

        $output = ['start' => '', 'end' => '', 'trial' => ''];

        //calculate start date
        $start_date = Subscription::end_date($business_id);
        $output['start'] = $start_date->toDateString();

        //Calculate end date
        if($package->interval == 'days'){
            $output['end'] = $start_date->addDays($package->interval_count)->toDateString();
        } elseif($package->interval == 'months'){
            $output['end'] = $start_date->addMonths($package->interval_count)->toDateString();
        } elseif($package->interval == 'years'){
            $output['end'] = $start_date->addYears($package->interval_count)->toDateString();
        }
        
        $output['trial'] = $start_date->addDays($package->trial_days);

        return $output;
    }

    public function success(Request $request) 
    {
        $sslc = new SSLCommerz();
        #Start to received these value from session. which was saved in index function.
        $tran_id = $_SESSION["tran_id"];
        #End to received these value from session. which was saved in index function.

        #Check order status in order tabel against the transaction id or order id.
        $detials = DB::table('subscriptions')
                            ->where('payment_transaction_id','=',$tran_id)
                            ->select('subscriptions.*')->first();

        if($detials->status=='waiting')
        {
            
            $validation = $sslc->orderValidate($tran_id,$_SESSION["tran_id_currency"],$_SESSION["tran_id_amount"], $request->all());
            if(!$validation)
            {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */ 
                $update = DB::table('subscriptions')
                            ->where('payment_transaction_id','=', $tran_id)
                            ->update(['status' => 'approved']);
                $status = "Transaction is successfully Complete";
                return view('others.TransactionStatus',['statusCode'=>200,'status'=>$status,'tran_id'=>$tran_id]);
            }
            else
            {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */ 
                
                $update = DB::table('subscriptions')
                            ->where('payment_transaction_id', $tran_id)
                            ->update(['status' => 'declined']);
                
                $status = "Transaction Validation Failed";
                return view('others.TransactionStatus',['statusCode'=>400,'status'=>$status]);
            }    
        }
        else if($detials->status=='approved')
        {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            $status = "Transaction is successfully Complete";
            return view('others.TransactionStatus',['statusCode'=>200,'status'=>$status,'tran_id'=>$tran_id]);
        }
        else
        {
             #That means something wrong happened. You can redirect customer to your product page.
            
            $status = "Transaction is not Complete";
            return view('others.TransactionStatus',['statusCode'=>400,'status'=>$status]);
        }         


    }
    
    // if transection is failed
    
    public function fail(Request $request) 
    {
         $tran_id = $_SESSION["tran_id"];
         
         $detials = DB::table('subscriptions')
                    ->where('payment_transaction_id','=',$tran_id)
                    ->select('subscriptions.*')->first();

        if($detials->status=='waiting')
        {
            DB::table('subscriptions')
                ->where('payment_transaction_id','=',$tran_id)
                ->update(['status' => 'waiting']);
             
            $status = "Transaction is Falied";
            return view('others.TransactionStatus',['statusCode'=>400,'status'=>$status]);
        }
        else if($detials->status=='approved')
        {
            $status = "Transaction is already successfully Complete";
            echo $status;
           return view('others.TransactionStatus',['statusCode'=>200,'status'=>$status]);
        }  
        else
        {
            $status = "Transaction is Falied";
            return view('others.TransactionStatus',['statusCode'=>400,'status'=>$status]); 
        }        
                            
    }

     public function cancel(Request $request) 
    {
        $tran_id = $_SESSION["tran_id"];

        $detials = DB::table('subscriptions')
                    ->where('payment_transaction_id','=',$tran_id)
                    ->select('subscriptions.*')->first();

        if($detials->status=='waiting')
        {
            DB::table('subscriptions')
                ->where('payment_transaction_id','=',$tran_id)
                ->update(['status' => 'declined']);
            
            $status = "Transaction is Cancled";
            return view('others.TransactionStatus',['statusCode'=>400,'status'=>$status]);                 
        }
        else if($detials->status=='approved')
        {
            $status = "Transaction is already successfully Complete";
            return view('others.TransactionStatus',['statusCode'=>200,'status'=>$status]);
        }  
        else
        {
            $status = "Transaction is Cancled";
            return view('others.TransactionStatus',['statusCode'=>400,'status'=>$status]);   
        }                 

        
    }
    public function ipn(Request $request) 
    {
        #Received all the payement information from the gateway  
        if($request->input('tran_id')) #Check transation id is posted or not.
        {
            $tran_id = $request->input('tran_id');
            #Check order status in order tabel against the transaction id or order id.
            $detials = DB::table('subscriptions')
                            ->where('payment_transaction_id','=',$tran_id)
                            ->select('subscriptions.*')->first();

                if($detials->status =='waiting')
                {
                    $sslc = new SSLCommerz();
                    $validation = $sslc->orderValidate($tran_id,$_SESSION["tran_id_currency"],$_SESSION["tran_id_amount"], $request->all());
                    if($validation) 
                    {
                        /*
                        That means IPN worked. Here you need to update order status
                        in order table as Processing or Complete.
                        Here you can also sent sms or email for successfull transaction to customer
                        */ 
                        $update = DB::table('subscriptions')
                            ->where('payment_transaction_id','=', $tran_id)
                            ->update(['status' => 'approved']);
                        
                        $status = "Transaction is successfully Complete";
                        return view('others.TransactionStatus',['statusCode'=>200,'status'=>$status,'tran_id'=>$tran_id]);
                    }
                    else
                    {
                        /*
                        That means IPN worked, but Transation validation failed.
                        Here you need to update order status as Failed in order table.
                        */ 
                        $update = DB::table('subscriptions')
                            ->where('payment_transaction_id','=', $tran_id)
                            ->update(['status' => 'waiting']);      
                        
                        $status = "Transaction Validation Failed";
                        return view('others.TransactionStatus',['statusCode'=>400,'status'=>$status]);
                    } 
                     
                }
                else if($detials->status == 'approved')
                {
                    
                  #That means Order status already updated. No need to udate database.
                     
                    $status = "Transaction is already Completed";
                    return view('others.TransactionStatus',['statusCode'=>200,'status'=>$status,'tran_id'=>$tran_id]);
                }
                else
                {
                   #That means something wrong happened. You can redirect customer to your product page.
                     
                    $status = "Invalid Transection";
                    return view('others.TransactionStatus',['statusCode'=>400,'status'=>$status]);
                }  
        }
        else
        {
            $status = "Invalid Data";
            return view('others.TransactionStatus',['statusCode'=>400,'status'=>$status]);
        }      
    }

}
