<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    public function index(Request $request)
    {
    	$token 				=	$request->input('stripeToken');
    	$email				=	$request->input('stripeEmail');
    	$amount 			=	'999';
    	$currency 			=	'usd';
    	$description		=	'Description here';
    	$custom_descriptor	=	'Custom descriptor';

    	if ( !null($token) ) {
    		$payment 	=	$this->makeCall($token,$amount,$currency,$description,$custom_descriptor);
    		// VALIDATE $payment here
    	}
    }

    private function makeCall($token)
    {

		$data	=	"amount=$amount&currency=$currency&description=$description&source=$token&statement_descriptor=$custom_descriptor";

		$curl 	= 	curl_init();

		curl_setopt_array($curl, array(
		    CURLOPT_URL => "https://api.stripe.com/v1/charges",
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => "",
		    CURLOPT_MAXREDIRS => 10,
		    CURLOPT_TIMEOUT => 30000,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => "POST",
		    CURLOPT_USERPWD=>"STRIPE_KEY_HERE",
		    CURLOPT_POSTFIELDS => $data,
		    CURLOPT_HTTPHEADER => array(
		    	// Set here requred headers
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
}
