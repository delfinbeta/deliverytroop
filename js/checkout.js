/*********************************************/
/*****                                   *****/
/*****  Documento JS                     *****/
/*****                                   *****/
/*****  Fecha: 08/04/2017                *****/
/*****  Autor: Lcda. Dayan Betancourt    *****/
/*****                                   *****/
/*********************************************/

$(document).ready(function() {
	Stripe.setPublishableKey('pk_test_x25yVvwspLJ2fa80hzqWX2of');

	//----------------------------------------------------
	//  Checkout
	//----------------------------------------------------
	$("#form_order").submit(function(ev) {
		ev.preventDefault();

		var enviar = true;
		var $campoNombre = $(this).find('input[name="nombre"]');
		var $campoEmail = $(this).find('input[name="email"]');
		var $campoTelefono = $(this).find('input[name="telefono"]');
		var $campoDireccion = $(this).find('input[name="direccion"]');
		var $campoZipcode = $(this).find('input[name="zipcode"]');
		var $campoCiudad = $(this).find('input[name="ciudad"]');
		var $campoHotelID = $(this).find('input[name="hotel_id"]');
		var $campoHabitacion = $(this).find('input[name="habitacion"]');
		var $campoPedido = $(this).find('input[name="pedido"]');
		var $campoSubtotal = $(this).find('input[name="subtotal"]');
		var $campoTotal = $(this).find('input[name="total"]');
		var $campoTarjeta = $(this).find('input[name="tarjeta"]');
		var $campoMes = $(this).find('input[name="mes"]');
		var $campoAno = $(this).find('input[name="ano"]');
		var $campoCVC = $(this).find('input[name="cvc"]');
		var $campoBillingZip = $(this).find('input[name="billing_zip"]');

		var nombre = $campoNombre.val();
		var email = $campoEmail.val();
		var telefono = $campoTelefono.val();
		var direccion = $campoDireccion.val();
		var zipcode = $campoZipcode.val();
		var ciudad = $campoCiudad.val();
		var hotel_id = $campoHotelID.val();
		var habitacion = $campoHabitacion.val();
		var pedido = $campoPedido.val();
		var subtotal = $campoSubtotal.val();
		var total = $campoTotal.val();
		var tarjeta = $campoTarjeta.val();
		var mes = $campoMes.val();
		var ano = $campoAno.val();
		var cvc = $campoCVC.val();
		var billing_zip = $campoBillingZip.val();
		
		$(".form-group").removeClass('has-error');
		$(".help-block").html("");
		$("#error").addClass('hidden');

		if((billing_zip == '') || (!/^([0-9])*$/.test(billing_zip))) {
			$campoBillingZip.parents('.form-group').addClass('has-error');
			$("#bloqueErrorBillingZip").html("Billing Zip is required");
			$campoBillingZip.focus();
			enviar = false;
		}

		if((cvc == '') || (!/^([0-9])*$/.test(cvc))) {
			$campoCVC.parents('.form-group').addClass('has-error');
			$("#bloqueErrorCVC").html("CVC is required");
			$campoCVC.focus();
			enviar = false;
		}

		if((ano == '') || (!/^([0-9])*$/.test(ano))) {
			$campoAno.parents('.form-group').addClass('has-error');
			$("#bloqueErrorAno").html("Expiration Year is required");
			$campoAno.focus();
			enviar = false;
		}

		if((mes == '') || (!/^([0-9])*$/.test(mes))) {
			$campoMes.parents('.form-group').addClass('has-error');
			$("#bloqueErrorMes").html("Expiration Month is required");
			$campoMes.focus();
			enviar = false;
		}

		if((tarjeta == '') || (!/^([0-9])*$/.test(tarjeta))) {
			$campoTarjeta.parents('.form-group').addClass('has-error');
			$("#bloqueErrorTarjeta").html("Card Number is required");
			$campoTarjeta.focus();
			enviar = false;
		}

		if((hotel_id != 0) && (habitacion == '')) {
			$campoHabitacion.parents('.form-group').addClass('has-error');
			$("#bloqueErrorHabitacion").html("Room is required");
			$campoHabitacion.focus();
			enviar = false;
		}

		if(ciudad == '') {
			$campoCiudad.parents('.form-group').addClass('has-error');
			$("#bloqueErrorCiudad").html("City is required");
			$campoCiudad.focus();
			enviar = false;
		}

		if(zipcode == '') {
			$campoZipcode.parents('.form-group').addClass('has-error');
			$("#bloqueErrorZipcode").html("Zipcode is required");
			$campoZipcode.focus();
			enviar = false;
		}

		if(direccion == '') {
			$campoDireccion.parents('.form-group').addClass('has-error');
			$("#bloqueErrorDireccion").html("Address is required");
			$campoDireccion.focus();
			enviar = false;
		}

		if(telefono == '') {
			$campoTelefono.parents('.form-group').addClass('has-error');
			$("#bloqueErrorTelefono").html("Phone is required");
			$campoTelefono.focus();
			enviar = false;
		}

		if(email == '') {
			$campoEmail.parents('.form-group').addClass('has-error');
			$("#bloqueErrorEmail").html("Email is required");
			$campoEmail.focus();
			enviar = false;
		}

		if(nombre == '') {
			$campoNombre.parents('.form-group').addClass('has-error');
			$("#bloqueErrorNombre").html("Name is required");
			$campoNombre.focus();
			enviar = false;
		}

		if(pedido <= 0) {
			$("#error").removeClass('hidden');
			$("#msjError").html("You currently do not have any items. Please add items to your cart before checking out.");
			$(window).scrollTop(0);
			enviar = false;
		} else {
			if(subtotal < 10) {
				$("#error").removeClass('hidden');
				$("#msjError").html("Minimum purchase 10$USD.");
				$(window).scrollTop(0);
				enviar = false;
			}

			if(total > 250) {
				$("#error").removeClass('hidden');
				$("#msjError").html("Maximum purchase 250$USD.");
				$(window).scrollTop(0);
				enviar = false;
			}
		}

		if(enviar) {
			console.log("Enviado");

			// Disable the submit button to prevent repeated clicks:
			$(this).find('button[type="submit"]').prop('disabled', true);

			// Request a token from Stripe:
			Stripe.card.createToken($(this), stripeResponseHandler);
		}
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Stripe Function
	//----------------------------------------------------
	function stripeResponseHandler(status, response) {
	  // Grab the form:
	  var $form = $('#form_order');

	  if(response.error) { // Problem!
	    // Show the errors on the form:
	    $('#error').removeClass('hidden');
	    $('#msjError').html(response.error.message);
	    $form.find('button[type="submit"]').prop('disabled', false); // Re-enable submission
	    $(window).scrollTop(0);
	  } else { // Token was created!
	    // Get the token ID:
	    var token = response.id;

	    // Insert the token ID into the form so it gets submitted to the server:
	    $form.append($('<input type="hidden" name="stripeToken" />').val(token));

	    // Submit the form:
	    $form.get(0).submit();
	  }
	};
	//----------------------------------------------------
});