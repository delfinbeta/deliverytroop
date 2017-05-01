<?php
require_once("stripe-php-3.23.0/init.php");

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_WMMh16yON2GEPdfNJ1fXpWM0");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];

// Create a Customer
$customer = \Stripe\Customer::create(array(
  "source" => $token,
  "description" => "Cliente")
);

// Charge the Customer instead of the card
// \Stripe\Charge::create(array(
//   "amount" => 1000, // Amount in cents
//   "currency" => "usd",
//   "customer" => $customer->id)
// );

// Create a charge: this will charge the user's card
try {
  $charge = \Stripe\Charge::create(array(
    "amount" => 1000, // Amount in cents
    "currency" => "usd",
    "customer" => $customer->id,
    "metadata" => array("order_id" => "6735")
    ));
} catch(\Stripe\Error\Card $e) {
  // The card has been declined
  echo "ERROR";
}

// YOUR CODE: Save the customer ID and other info in a database for later!

// YOUR CODE: When it's time to charge the customer again, retrieve the customer ID!

/*\Stripe\Charge::create(array(
  "amount"   => 1500, // $15.00 this time
  "currency" => "usd",
  "customer" => $customerId // Previously stored, then retrieved
  ));*/

echo "Procesar Pago";
?>