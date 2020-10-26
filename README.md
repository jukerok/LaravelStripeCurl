# LaravelStripeCurl
Integrate Stripe in Laravel using curl

This controller works with Stripe's Checkout integration https://stripe.com/docs/checkout

## How it works
Steps:
1. Place StripePaymentController.php in app/Http/Controller
2. Edit the controller, use your Stripe key in`CURLOPT_USERPWD`
3. Use your own validations for validating the payment. 

and Voala! 
