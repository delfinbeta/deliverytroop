<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_comentario.php");

// Objetos
$comentario = new Comentario($conexion);

$error = false;

// Recibir Datos
if(isset($_POST['id'])) { $id_comentario = $_POST['id']; } else { $id_comentario = 0; }
if(isset($_POST['respuesta'])) { $respuesta = $_POST['respuesta']; } else { $respuesta = ''; }

// Validaciones
if(!$error) {
	if($comentario->responder($id_comentario, $respuesta)) {
		echo json_encode(array("error" => false, "mensaje" => 'Comentario Respondido'));
	} else {
		echo json_encode(array("error" => true, "mensaje" => $comentario->error));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $comentario->error));
}
?>