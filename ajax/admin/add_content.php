<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_contenido.php");

// Objetos
$contenido = new Contenido($conexion);

$error = false;

// Recibir Datos
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }
if(isset($_POST['descripcion'])) { $descripcion = $_POST['descripcion']; } else { $descripcion = ''; }

// Validaciones

if(!$error) {
	if($contenido->insertar($nombre, $descripcion)) {
		echo json_encode(array("error" => false, "mensaje" => 'Contenido Agregado'));
	} else {
		echo json_encode(array("error" => true, "mensaje" => $contenido->error));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $contenido->error));
}
?>