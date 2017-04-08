<?php
require_once("../configuracion/inicio.php");

// Clases
require_once("../clases/clase_comentario.php");

// Objetos
$comentario = new Comentario($conexion);

$error = false;

// Recibir Datos
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }
if(isset($_POST['email'])) { $email = $_POST['email']; } else { $email = ''; }
if(isset($_POST['mensaje'])) { $mensaje = $_POST['mensaje']; } else { $mensaje = ''; }

// Validaciones

if(!$error) {
	if($comentario->insertar($nombre, $email, $mensaje)) {
		echo json_encode(array("error" => false, "mensaje" => 'Message sent'));
	} else {
		echo json_encode(array("error" => true, "mensaje" => $comentario->error));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $comentario->error));
}
?>