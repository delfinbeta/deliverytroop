<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<title>Stripe</title>
	<meta name="creator" content="www.tecnod20.com" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
	<h1>Stripe</h1>
	<form action="procesar_pago.php" method="POST" id="payment-form">
	  <span class="payment-errors"></span>

	  <div class="form-row">
	    <label>
	      <span>Card Number</span>
	      <input type="text" size="20" data-stripe="number">
	    </label>
	  </div>

	  <div class="form-row">
	    <label>
	      <span>Expiration (MM/YY)</span>
	      <input type="text" size="2" data-stripe="exp_month">
	    </label>
	    <span> / </span>
	    <input type="text" size="2" data-stripe="exp_year">
	  </div>

	  <div class="form-row">
	    <label>
	      <span>CVC</span>
	      <input type="text" size="4" data-stripe="cvc">
	    </label>
	  </div>

	  <div class="form-row">
	    <label>
	      <span>Billing Zip</span>
	      <input type="text" size="6" data-stripe="address_zip">
	    </label>
	  </div>

	  <input type="submit" class="submit" value="Submit Payment">
	</form>
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script type="text/javascript">
	  Stripe.setPublishableKey('pk_test_Uk8unTsjNUxpFLI4DZBvyiGu');
	  $(function() {
		  var $form = $('#payment-form');
		  $form.submit(function(event) {
		    // Disable the submit button to prevent repeated clicks:
		    $form.find('.submit').prop('disabled', true);

		    // Request a token from Stripe:
		    Stripe.card.createToken($form, stripeResponseHandler);

		    // Prevent the form from being submitted:
		    return false;
		  });

		  function stripeResponseHandler(status, response) {
			  // Grab the form:
			  var $form = $('#payment-form');

			  if (response.error) { // Problem!

			    // Show the errors on the form:
			    $form.find('.payment-errors').text(response.error.message);
			    $form.find('.submit').prop('disabled', false); // Re-enable submission

			  } else { // Token was created!

			    // Get the token ID:
			    var token = response.id;

			    // Insert the token ID into the form so it gets submitted to the server:
			    $form.append($('<input type="text" name="stripeToken">').val(token));

			    // Submit the form:
			    $form.get(0).submit();
			  }
			};
		});
	</script>
</body>
</html>