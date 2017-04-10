<?php
require("../configuracion/inicio.php");

// Clases
require("../clases/clase_producto.php");

// Objetos
$producto = new Producto($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_producto = $_POST['id']; } else { $id_producto = 0; }

if($producto->datos($id_producto)) {
	echo json_encode(array("error" => false, "mensaje" => 'Producto Consultado', 
												 "nombre" => $producto->nombre, 
												 "descripcion" => $producto->descripcion, 
												 "imagen" => $producto->imagen));
} else {
	echo json_encode(array("error" => true, "mensaje" => $producto->error));
}
?>