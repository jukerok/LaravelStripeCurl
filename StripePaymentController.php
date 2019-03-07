<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
	protected $token;
	protected $email;
	protected $amount;
	protected $currency;
	protected $description;
	protected $custom_descriptor;
	protected $status;
	protected $id;
	protected $paidAmount;
	protected $source_id;
	public $url 	=	'https://api.stripe.com/v1/charges';

	
	public function __construct(Request $request) 
	{
		$this->token 				=	$request->input('stripeToken');
    		$this->email				=	$request->input('stripeEmail');
    		$this->currency 			=	'CURRENCY HERE';
    		$this->description			= 	'DESCRIPTION HERE';
    		$this->custom_descriptor 		= 	'CUSTOM DESCRIPTOR HERE';
		$this->amount 				=	'AMOUNT HERE';
	}

    	public function index()
    	{
    		if ( !empty($this->token) ) {
    			$payment 			=	$this->makeCall();
    			$this->status			=	$payment->status;
    			$this->id 			=	$payment->id;
    			$this->paidAmount 		=	$payment->amount;
    			$this->source_id 		=	$payment->source->id;
    			$this->validatePayment();
    		}
   	 }

    	private function makeCall($token)
    	{

		$data	=	"amount=$this->amount&currency=$currency&description=$description&source=$token&statement_descriptor=$custom_descriptor";

		$curl 	= 	curl_init();

		curl_setopt_array($curl, array(
		    CURLOPT_URL => $this->url,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => "",
		    CURLOPT_MAXREDIRS => 10,
		    CURLOPT_TIMEOUT => 30000,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => "POST",
		    CURLOPT_USERPWD=>"STRIPE_KEY_HERE",
		    CURLOPT_POSTFIELDS => $data,
		    CURLOPT_HTTPHEADER => array(
		        "accept: */*",
		        "accept-language: en-US,en;q=0.8",
		        "content-type: application/x-www-form-urlencoded",
		    ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		return $response; 
    	} 

    	private function validatePayment()
    	{
    		//VALIDATE THE PAYMENT HERE
    		dd($this->status);
    	}

}
