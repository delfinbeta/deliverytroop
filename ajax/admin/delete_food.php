<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_producto.php");

// Objetos
$producto = new Producto($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_producto = $_POST['id']; } else { $id_producto = 0; }

if($producto->desactivar($id_producto)) {
	echo json_encode(array("error" => false, "mensaje" => 'Producto Eliminado (D)'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $producto->error));
}
?>