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
				location.href = "restaurants.php?msjH=1";
			}
		}, "json");

		$('#ProductoDetalles').modal('show');
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Product Details
	//----------------------------------------------------
	$('button[name="ordenar"]').click(function(ev) {
		ev.preventDefault();

		var producto = $(this).data('id');
		console.log("Producto = " + producto);

		var $campoProducto = $('#form_ordenar').find('input[name="producto"]');
		var $campoPrecio = $('#form_ordenar').find('input[name="precio"]');
		var $campoOpcH1 = $('#form_ordenar').find('input[name="opch1"]');
		var $campoOpcH2 = $('#form_ordenar').find('input[name="opch2"]');

		$.post("ajax/order.php", { id: producto }, function(data) {
			console.log("Error: " + data.error);
			console.log("Mensaje: " + data.mensaje);

			if(!data.error) {
				$campoProducto.val(producto);
				$('#ProductoOrdenar .modal-title').html(data.nombre);
				$('#precio').html(data.precio);
				$campoPrecio.val(data.precio);
				$campoOpcH1.val(data.opc1);
				$campoOpcH2.val(data.opc2);
				$('#gopc1').html(data.selects1);
				$('#gopc2').html(data.selects2);

				$("#opcion1").change(function() {
					var valor = $(this).val();
					$campoOpcH1.val(valor);

					// console.log("Producto V1 = " + producto);
					// console.log("Opcion 1 = " + valor);
					// console.log("Opcion 2 = " + $campoOpcH2.val());

					$.post("ajax/price.php", { producto: producto, opcion1: valor, opcion2: $campoOpcH2.val() }, function(data) {
						$('#precio').html(data);
						$campoPrecio.val(data);
					});
				});

				$("#opcion2").change(function() {
					var valor = $(this).val();
					$campoOpcH2.val(valor);

					// console.log("Producto V2 = " + producto);
					// console.log("Opcion 1 = " + $campoOpcH1.val());
					// console.log("Opcion 2 = " + valor);

					$.post("ajax/price.php", { producto: producto, opcion1: $campoOpcH1.val(), opcion2: valor }, function(data) {
						$('#precio').html(data);
						$campoPrecio.val(data);
					});
				});
			}
		}, "json");

		$('#ProductoOrdenar').modal('show');
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Order
	//----------------------------------------------------
	$("#form_ordenar").submit(function(ev) {
		ev.preventDefault();

		var enviar = true;
		var $campoProducto = $(this).find('input[name="producto"]');
		var $campoPrecio = $(this).find('input[name="precio"]');
		var $campoCantidad = $(this).find('input[name="cantidad"]');

		var producto = $campoProducto.val();
		var precio = $campoPrecio.val();
		var cantidad = $campoCantidad.val();
		var url = $(this).find('input[name="url"]').val();
		
		$(".form-group").removeClass('has-error');
		$(".help-block").html("");
		$("#error").addClass('hidden');

		if(producto <= 0) {
			$("#error").removeClass('hidden');
			$("#msjError").html("Product is required");
			enviar = false;
		}

		if(precio == '---') {
			$("#error").removeClass('hidden');
			$("#msjError").html("Price is required");
			enviar = false;
		}

		if((cantidad == '') || (!/^([0-9])*$/.test(cantidad))) {
			$campoCantidad.parents('.form-group').addClass('has-error');
			$("#bloqueErrorCantidad").html("Quantity is required");
			enviar = false;
		}

		if(enviar) {
			console.log("Enviado");
			var formData = new FormData(this);  // Creamos los datos a enviar con el formulario

			$.ajax({
        url: "ajax/order_add.php",        // URL destino
        type: "POST",
        data: formData,                   // Datos del Formulario
        dataType: "JSON",
        processData: false,               // Evitamos que JQuery procese los datos, daría error
        contentType: false,               // No especificamos ningún tipo de dato
        cache: false
	    }).done(function(data) {
	    	console.log("Error: " + data.error);
				console.log("Mensaje: " + data.mensaje);

				if(data.error) {
					$("#error").removeClass('hidden');
					$("#msjError").html(data.mensaje);
				} else {
					document.getElementById("form_ordenar").reset();
					location.href = url;
				}
		  }).fail(function() {
		    $('#error').removeClass('hidden');
		    $('#msjError').html("Ha ocurrido un error. Contacte a Sistemas.");
		  });
		}
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Delete Order
	//----------------------------------------------------
	$(".eliminar-pedido").click(function(ev) {
		ev.preventDefault();

		var $boton = $(this);
		var posicion = $boton.data('pos');
		console.log("Posicion = " + posicion);

		$.post("ajax/order_remove.php", { posicion: posicion }, function(data) {
			console.log("Error: " + data.error);
			console.log("Mensaje: " + data.mensaje);

			if(!data.error) {
				// $boton.closest('tr').remove();
				location.href = "order.php";
			}
		}, "json");
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Tips
	//----------------------------------------------------
	$(".propina").click(function(ev) {
		ev.preventDefault();

		var $campoSubtotal = $("#form_order").find('input[name="subtotal"]');
		var $campoDelivery = $("#form_order").find('input[name="delivery"]');
		var $campoTax = $("#form_order").find('input[name="tax"]');
		var $campoPropina = $("#form_order").find('input[name="propina"]');
		var $campoTotal = $("#form_order").find('input[name="total"]');

		var valor = $(this).data('valor');
		var subtotal = parseFloat($campoSubtotal.val());
		var delivery = parseFloat($campoDelivery.val());
		var tax = parseFloat($campoTax.val());
		var propina = (subtotal * valor) / 100;
		var total = parseFloat(subtotal.toFixed(2)) + parseFloat(delivery.toFixed(2)) + parseFloat(tax.toFixed(2)) + parseFloat(propina.toFixed(2));

		$(".propina").removeClass('boton-amarillo2');  // Desmarcar Todos (anterior)
		$(this).addClass('boton-amarillo2');  // Marcar actual

		$("#msjPropina").html(propina.toFixed(2));
		$("#msjTotal").html(total.toFixed(2));
		$campoPropina.val(propina.toFixed(2));
		$campoTotal.val(total.toFixed(2));
	});
	//----------------------------------------------------
});