<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_restaurante.php");

// Objetos
$restaurante = new Restaurante($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_restaurante = $_POST['id']; } else { $id_restaurante = 0; }

if($restaurante->desactivar($id_restaurante)) {
	echo json_encode(array("error" => false, "mensaje" => 'Restaurante Eliminado (D)'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $restaurante->error));
}
?>