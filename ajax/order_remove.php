<?php
require("../configuracion/inicio.php");

// Clases
require("../clases/clase_producto.php");

// Objetos
$producto = new Producto($conexion);

if(isset($_POST['posicion'])) { $posicion = $_POST['posicion']; } else { $posicion = '---'; }

// Determinar el Producto
$arreglo = explode("-", $posicion);
$id_producto = $arreglo[0];

if($producto->datos($id_producto)) {
	$id_restaurante = $producto->obtener_restaurante();

	// Eliminar la Presentacion
	$pedido = array();

	$pedido = $_SESSION['orden']['pedido'];  // Asignamos a la variable $carro los valores guardados en la sessión

	unset($pedido[$posicion]);               // La función unset borra el elemento de un array que le pasemos por parámetro.
																					 // En este caso borramos el elemento cuyo id le pasemos a la página por la url
	
	$_SESSION['orden']['pedido'] = $pedido;  // Actualizamos el arreglo carrito de compras en la sesión

	// Bucar el Restaurante en otros Productos
	$encontrado = false;
	foreach($pedido as $item) {
		if($producto->datos($item['producto'])) {
			$id_restaurante2 =  $producto->obtener_restaurante();

			if($id_restaurante == $id_restaurante2) { $encontrado = true; }
		}
	}

	// Eliminar el Restaurante
	if(!$encontrado) {
		$restaurantes = $_SESSION['orden']['restaurantes'];
		$pos = array_search($id_restaurante, $restaurantes);
		unset($restaurantes[$pos]);
		$_SESSION['orden']['restaurantes'] = $restaurantes;
	}

	echo json_encode(array("error" => false, "mensaje" => 'Eliminado del Carrito'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $producto->error));
}
?>