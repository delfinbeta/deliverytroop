<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_zipcode.php");

// Objetos
$zipcode = new Zipcode($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_zipcode = $_POST['id']; } else { $id_zipcode = 0; }

if($zipcode->desactivar($id_zipcode)) {
	echo json_encode(array("error" => false, "mensaje" => 'Zipcode Eliminado (D)'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $zipcode->error));
}
?>