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
	//  Eliminar
	//----------------------------------------------------
	$(".boton-eliminar").click(function(ev) {
		ev.preventDefault();

    if(confirm('¿Esta seguro que desea Eliminar este Registro?')) {
    	var id = $(this).data('reg');

    	$.post("../../ajax/admin/delete_order.php", { id: id }, function(data) {
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
	//  Estatus Orden
	//----------------------------------------------------
	$(".estatus").click(function(ev) {
		ev.preventDefault();

  	var id = $(this).data('reg');
  	var estado = $(this).data('estado');

  	$.post("../../ajax/admin/status_order.php", { id: id, estado: estado }, function(data) {
			console.log("Error: " + data.error);
			console.log("Mensaje: " + data.mensaje);

			if(data.error) {
				$("#error").removeClass('hidden');
				$("#msjError").html(data.mensaje);
			} else {
				location.href = "index.php?m=M";
			}
		}, "json");
  });
	//----------------------------------------------------
});