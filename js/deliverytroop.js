/*********************************************/
/*****                                   *****/
/*****  Documento JS                     *****/
/*****                                   *****/
/*****  Fecha: 08/04/2017                *****/
/*****  Autor: Lcda. Dayan Betancourt    *****/
/*****                                   *****/
/*********************************************/

$(document).ready(function() {
	//----------------------------------------------------
	//  Zipcode
	//----------------------------------------------------
	$("#form_zipcode").submit(function(ev) {
		ev.preventDefault();

		var enviar = true;
		var $campoZipcode = $(this).find('input[name="zipcode"]');
		var zipcode = $campoZipcode.val();

		$(".form-group").removeClass('has-error');
		$(".help-block").html("");
		$("#errorZipcode").addClass('hidden');

		if(zipcode == '') {
			$campoZipcode.parents('.form-group').addClass('has-error').css("background-color", "#FFFFFF");
			$("#bloqueErrorZipcode").html("Zipcode is required");
			enviar = false;
		}

		if(enviar) {
			var formData = new FormData(this);  // Creamos los datos a enviar con el formulario

			$.ajax({
        url: "ajax/zipcode.php",      // URL destino
        type: "POST",
        data: formData,               // Datos del Formulario
        dataType: "JSON",
        processData: false,           // Evitamos que JQuery procese los datos, daría error
        contentType: false,           // No especificamos ningún tipo de dato
        cache: false
	    }).done(function(data) {
	    	console.log("Error: " + data.error);
				console.log("Mensaje: " + data.mensaje);

				if(data.error) {
					$("#errorZipcode").removeClass('hidden');
					$("#msjErrorZipcode").html(data.mensaje);
				} else {
					location.href = "restaurants.php";
				}
		  }).fail(function() {
		    $('#error').removeClass('hidden');
		    $('#msjError').html("Ha ocurrido un error. Contacte a Sistemas.");
		  });
		}
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Compra
	//----------------------------------------------------
	$("#form_compra").submit(function(ev) {
		ev.preventDefault();

		var enviar = true;
		var $campoZipcode = $(this).find('input[name="zipcode"]');
		var $campoDireccion = $(this).find('input[name="direccion"]');

		var zipcode = $campoZipcode.val();
		var direccion = $campoDireccion.val();

		$(".form-group").removeClass('has-error');
		$(".help-block").html("");
		$("#errorZipcode").addClass('hidden');

		if(zipcode == '') {
			$campoZipcode.parents('.form-group').addClass('has-error');
			$("#bloqueErrorOZipcode").html("Zipcode is required");
			enviar = false;
		}

		if(direccion == '') {
			$campoDireccion.parents('.form-group').addClass('has-error');
			$("#bloqueErrorODireccion").html("Address is required");
			enviar = false;
		}

		if(enviar) {
			var formData = new FormData(this);  // Creamos los datos a enviar con el formulario

			$.ajax({
        url: "ajax/compra.php",      // URL destino
        type: "POST",
        data: formData,               // Datos del Formulario
        dataType: "JSON",
        processData: false,           // Evitamos que JQuery procese los datos, daría error
        contentType: false,           // No especificamos ningún tipo de dato
        cache: false
	    }).done(function(data) {
	    	console.log("Error: " + data.error);
				console.log("Mensaje: " + data.mensaje);

				if(data.error) {
					console.log(data.mensaje);
				} else {
					location.href = "order.php";
				}
		  }).fail(function() {
		    $('#error').removeClass('hidden');
		    $('#msjError').html("Ha ocurrido un error. Contacte a Sistemas.");
		  });
		}
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Contacto
	//----------------------------------------------------
	$("#form_contact").submit(function(ev) {
		ev.preventDefault();

		var enviar = true;
		var $campoNombre = $(this).find('input[name="nombre"]');
		var $campoEmail = $(this).find('input[name="email"]');
		var $campoMensaje = $(this).find('textarea[name="mensaje"]');

		var nombre = $campoNombre.val();
		var email = $campoEmail.val();
		var mensaje = $campoMensaje.val();
		
		$(".form-group").removeClass('has-error');
		$(".help-block").html("");
		$("#error").addClass('hidden');

		if(nombre == '') {
			$campoNombre.parents('.form-group').addClass('has-error');
			$("#bloqueErrorNombre").html("Name is required");
			enviar = false;
		}

		if(email == '') {
			$campoEmail.parents('.form-group').addClass('has-error');
			$("#bloqueErrorEmail").html("Email is required");
			enviar = false;
		}

		if(mensaje == '') {
			$campoMensaje.parents('.form-group').addClass('has-error');
			$("#bloqueErrorMensaje").html("Message is required");
			enviar = false;
		}

		if(enviar) {
			var formData = new FormData(this);  // Creamos los datos a enviar con el formulario

			$.ajax({
        url: "ajax/contact.php",      // URL destino
        type: "POST",
        data: formData,               // Datos del Formulario
        dataType: "JSON",
        processData: false,           // Evitamos que JQuery procese los datos, daría error
        contentType: false,           // No especificamos ningún tipo de dato
        cache: false
	    }).done(function(data) {
	    	console.log("Error: " + data.error);
				console.log("Mensaje: " + data.mensaje);

				if(data.error) {
					$("#error").removeClass('hidden');
					$("#msjError").html(data.mensaje);
				} else {
					$("#exito").removeClass('hidden');
					$("#msjExito").html(data.mensaje);
					document.getElementById("form_contact").reset();
				}
		  }).fail(function() {
		    $('#error').removeClass('hidden');
		    $('#msjError').html("Ha ocurrido un error. Contacte a Sistemas.");
		  });
		}
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Menu Select
	//----------------------------------------------------
	$(".menu_select").change(function() {
		var valor = $(this).val();
		var url = $(this).data('url');

		location.href = url + '=' + valor;
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Product Details
	//----------------------------------------------------
	$(".food-details").click(function(ev) {
		ev.preventDefault();

		var producto = $(this).data('id');
		console.log("Producto = " + producto);

		$.post("ajax/food.php", { id: producto }, function(data) {
			console.log("Error: " + data.error);
			console.log("Mensaje: " + data.mensaje);

			if(!data.error) {
				$('#ProductoDetalles .modal-title').html(data.nombre);
				$('#ProductoDetalles .prod-img').html('<img src="archivos_productos/' + data.imagen + '" alt="' + data.nombre + '" title="' + data.nombre + '" class="img-responsive center-block" />');
				$('#ProductoDetalles .prod-desc').html(data.descripcion);
			}
		}, "json");

		$('#ProductoDetalles').modal('show');
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Hotels
	//----------------------------------------------------
	$(".hotel").click(function(ev) {
		ev.preventDefault();

		var hotel = $(this).data('id');
		console.log("Hotel = " + hotel);

		$.post("ajax/hotel.php", { id: hotel }, function(data) {
			console.log("Error: " + data.error);
			console.log("Mensaje: " + data.mensaje);

			if(!data.error) {
				location.href = "order.php";
			}
		}, "json");

		$('#ProductoDetalles').modal('show');
	});
	//----------------------------------------------------
});