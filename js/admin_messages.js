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
	//  Modificar
	//----------------------------------------------------
	$("#form_modificar").submit(function(ev) {
		ev.preventDefault();

		var enviar = true;
		var $campoRespuesta = $(this).find('textarea[name="respuesta"]');

		var respuesta = $campoRespuesta.val();

		$(".form-group").removeClass('has-error');
		$(".help-block").html("");
		$("#error").addClass('hidden');

		if(respuesta == '') {
			$campoRespuesta.parents('.form-group').addClass('has-error');
			$("#bloqueErrorRespuesta").html("Reply is required");
			enviar = false;
		}

		if(enviar) {
			var formData = new FormData(this);  // Creamos los datos a enviar con el formulario

			$.ajax({
        url: "../../ajax/admin/edit_message.php",    // URL destino
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

    	$.post("../../ajax/admin/delete_message.php", { id: id }, function(data) {
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
});