<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_categoria.php");

// Objetos
$categoria = new Categoria($conexion);

$error = false;

// Recibir Datos
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }
if(isset($_POST['tipo'])) { $tipo = $_POST['tipo']; } else { $tipo = 0; }

// Validaciones

if(!$error) {
	if($categoria->insertar($tipo, $nombre)) {
		echo json_encode(array("error" => false, "mensaje" => 'Categoria Agregado'));
	} else {
		echo json_encode(array("error" => true, "mensaje" => $categoria->error));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $categoria->error));
}
?>