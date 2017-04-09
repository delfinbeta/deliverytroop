<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_opcion2.php");

// Objetos
$opcion2 = new Opcion2($conexion);

$error = false;

// Recibir Datos
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }

// Validaciones

if(!$error) {
	if($opcion2->insertar($nombre)) {
		echo json_encode(array("error" => false, "mensaje" => 'Opcion2 Agregado'));
	} else {
		echo json_encode(array("error" => true, "mensaje" => $opcion2->error));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $opcion2->error));
}
?>