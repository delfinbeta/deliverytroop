/*********************************************/
/*****                                   *****/
/*****  Documento JS                     *****/
/*****                                   *****/
/*****  Fecha: 18/01/2016                *****/
/*****  Autor: Lcda. Dayan Betancourt    *****/
/*****                                   *****/
/*********************************************/

$(document).ready(function() {
	//----------------------------------------------------
	//  Insertar
	//----------------------------------------------------
	$("#form_insertar").submit(function(ev) {
		ev.preventDefault();

		var enviar = true;
		var $campoTipo = $(this).find('select[name="tipo"]');
		var $campoNombre = $(this).find('input[name="nombre"]');
		var $campoResumen = $(this).find('input[name="resumen"]');

		var tipo = $campoTipo.val();
		var nombre = $campoNombre.val();
		var resumen = $campoResumen.val();
		
		$(".form-group").removeClass('has-error');
		$(".help-block").html("");
		$("#error").addClass('hidden');

		if(!tipo) {
			$campoTipo.parents('.form-group').addClass('has-error');
			$("#bloqueErrorTipo").html("Type is required");
			enviar = false;
		} else {
			if(tipo == 1) {
				var $campoRestaurante = $(this).find('select[name="restaurante"]');
				var restaurante = $campoRestaurante.val();

				if(restaurante == 0) {
					$campoRestaurante.parents('.form-group').addClass('has-error');
					$("#bloqueErrorRestaurante").html("Restaurant is required");
					enviar = false;
				}
			}

			if(tipo == 2) {
				var $campoCategoria = $(this).find('select[name="categoria"]');
				var categoria = $campoCategoria.val();

				if(categoria == 0) {
					$campoCategoria.parents('.form-group').addClass('has-error');
					$("#bloqueErrorCategoria").html("Category is required");
					enviar = false;
				}
			}
		}

		if(nombre == '') {
			$campoNombre.parents('.form-group').addClass('has-error');
			$("#bloqueErrorNombre").html("Name is required");
			enviar = false;
		}

		if(resumen == '') {
			$campoResumen.parents('.form-group').addClass('has-error');
			$("#bloqueErrorResumen").html("Resume is required");
			enviar = false;
		}

		if(enviar) {
			var formData = new FormData(this);  // Creamos los datos a enviar con el formulario

			$.ajax({
        url: "../../ajax/admin/add_food.php",    // URL destino
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
					location.href = "index.php?m=I";
				}
		  }).fail(function() {
		    $('#error').removeClass('hidden');
		    $('#msjError').html("Ha ocurrido un error. Contacte a Sistemas.");
		  });
		}
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Modificar
	//----------------------------------------------------
	$("#form_modificar").submit(function(ev) {
		ev.preventDefault();

		var enviar = true;
		var $campoTipo = $(this).find('select[name="tipo"]');
		var $campoNombre = $(this).find('input[name="nombre"]');
		var $campoResumen = $(this).find('input[name="resumen"]');

		var tipo = $campoTipo.val();
		var nombre = $campoNombre.val();
		var resumen = $campoResumen.val();
		
		$(".form-group").removeClass('has-error');
		$(".help-block").html("");
		$("#error").addClass('hidden');

		if(!tipo) {
			$campoTipo.parents('.form-group').addClass('has-error');
			$("#bloqueErrorTipo").html("Type is required");
			enviar = false;
		} else {
			if(tipo == 1) {
				var $campoRestaurante = $(this).find('select[name="restaurante"]');
				var restaurante = $campoRestaurante.val();

				if(restaurante == 0) {
					$campoRestaurante.parents('.form-group').addClass('has-error');
					$("#bloqueErrorRestaurante").html("Restaurant is required");
					enviar = false;
				}
			}

			if(tipo == 2) {
				var $campoCategoria = $(this).find('select[name="categoria"]');
				var categoria = $campoCategoria.val();

				if(categoria == 0) {
					$campoCategoria.parents('.form-group').addClass('has-error');
					$("#bloqueErrorCategoria").html("Category is required");
					enviar = false;
				}
			}
		}

		if(nombre == '') {
			$campoNombre.parents('.form-group').addClass('has-error');
			$("#bloqueErrorNombre").html("Name is required");
			enviar = false;
		}

		if(resumen == '') {
			$campoResumen.parents('.form-group').addClass('has-error');
			$("#bloqueErrorResumen").html("Resume is required");
			enviar = false;
		}

		if(enviar) {
			var formData = new FormData(this);  // Creamos los datos a enviar con el formulario

			$.ajax({
        url: "../../ajax/admin/edit_food.php",    // URL destino
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
					location.href = "index.php?m=M";
				}
		  }).fail(function() {
		    $('#error').removeClass('hidden');
		    $('#msjError').html("Ha ocurrido un error. Contacte a Sistemas.");
		  });
		}
	});
	//----------------------------------------------------

	//----------------------------------------------------
	//  Eliminar
	//----------------------------------------------------
	$(".boton-eliminar").click(function(ev) {
		ev.preventDefault();

    if(confirm('¿Esta seguro que desea Eliminar este Registro?')) {
    	var id = $(this).data('reg');

    	$.post("../../ajax/admin/delete_food.php", { id: id }, function(data) {
				console.log("Error: " + data.error);
				console.log("Mensaje: " + data.mensaje);

				if(data.error) {
					$("#error").removeClass('hidden');
					$("#msjError").html(data.mensaje);
				} else {
					location.href = "index.php?m=E";
				}
			}, "json");
    }
  });
	//----------------------------------------------------

	//----------------------------------------------------
	//  Modificar Presentaciones
	//----------------------------------------------------
	$("#form_presentacionesM").submit(function(ev) {
		ev.preventDefault();

		var formData = new FormData(this);  // Creamos los datos a enviar con el formulario

		$.ajax({
      url: "../../ajax/admin/edit_presentation.php",    // URL destino
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
				location.href = "index.php?m=M";
			}
	  }).fail(function() {
	    $('#error').removeClass('hidden');
	    $('#msjError').html("Ha ocurrido un error. Contacte a Sistemas.");
	  });
	});
	//----------------------------------------------------
});