<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_zipcode.php");

// Objetos
$zipcode = new Zipcode($conexion);

$error = false;

// Recibir Datos
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }
if(isset($_POST['codigo'])) { $codigo = $_POST['codigo']; } else { $codigo = ''; }

// Validaciones

if(!$error) {
	if($zipcode->insertar($nombre, $codigo)) {
		echo json_encode(array("error" => false, "mensaje" => 'Zipcode Agregado'));
	} else {
		echo json_encode(array("error" => true, "mensaje" => $zipcode->error));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $zipcode->error));
}
?>