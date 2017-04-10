/*********************************************/
/*****                                   *****/
/*****  Documento JS                     *****/
/*****                                   *****/
/*****  Fecha: 10/04/2017                *****/
/*****  Autor: Lcda. Dayan Betancourt    *****/
/*****                                   *****/
/*********************************************/

$(document).ready(function() {
	//----------------------------------------------------
	//  Menu Select
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
});