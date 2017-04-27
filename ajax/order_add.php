<?php
require("../configuracion/inicio.php");

// Clases
require("../clases/clase_presentacion.php");
require("../clases/clase_producto.php");

// Objetos
$presentacion = new Presentacion($conexion);
$producto = new Producto($conexion);

// Recibir Datos
if(isset($_POST['producto'])) { $id_producto = $_POST['producto']; } else { $id_producto = 0; }
if(isset($_POST['precio'])) { $precio = $_POST['precio']; } else { $precio = 0; }
if(isset($_POST['opcion1'])) { $id_opcion1 = $_POST['opcion1']; } else { $id_opcion1 = 0; }
if(isset($_POST['opcion2'])) { $id_opcion2 = $_POST['opcion2']; } else { $id_opcion2 = 0; }
if(isset($_POST['cantidad'])) { $cantidad = $_POST['cantidad']; } else { $cantidad = 0; }
if(isset($_POST['instrucciones'])) { $instrucciones = $_POST['instrucciones']; } else { $instrucciones = '---'; }

$pedido = array();
$restaurantes = array();

if(isset($_SESSION['orden']['pedido'])) { $pedido = $_SESSION['orden']['pedido']; }
if(isset($_SESSION['orden']['restaurantes'])) { $restaurantes = $_SESSION['orden']['restaurantes']; }

// Validad Restaurantes
if($producto->datos($id_producto)) {
	$id_restaurante = $producto->obtener_restaurante();
	$id_categoria = $producto->obtener_categoria();

	$total_restaurantes = count($restaurantes);

	if($id_restaurante > 0) {
		if(!in_array($id_restaurante, $restaurantes, true)) { $total_restaurantes++; }
	} else {
		if($id_categoria == 27) {
			if(!in_array($id_restaurante, $restaurantes, true)) { $total_restaurantes++; }
		}
	}

	if($total_restaurantes <= 3) {
		if($id_restaurante > 0) {
			if(!in_array($id_restaurante, $restaurantes, true)) { $restaurantes[] = $id_restaurante; }
		} else {
			if($id_categoria == 27) {
				if(!in_array($id_restaurante, $restaurantes, true)) { $restaurantes[] = $id_restaurante; }
			}
		}

		$_SESSION['orden']['restaurantes'] = $restaurantes;

		if($presentacion->datos($id_producto, $id_opcion1, $id_opcion2)) {
			$posicion = $id_producto.'-'.$id_opcion1.'-'.$id_opcion2;

			$pedido[$posicion] = array('posicion'       => $posicion,
																 'producto'       => $id_producto,
																 'opcion1'        => $id_opcion1,
																 'opcion2'        => $id_opcion2,
																 'precio'         => $precio,
																 'cantidad'       => $cantidad,
																 'instrucciones'  => $instrucciones);

			$_SESSION['orden']['pedido'] = $pedido;
			echo json_encode(array("error" => false, "mensaje" => "Agregado al Carrito"));
		} else {
			echo json_encode(array("error" => true, "mensaje" => $presentacion->error));
		}
	} else {
		echo json_encode(array("error" => true, "mensaje" => "Max. Restaurants = 3"));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $producto->error));
}
?>