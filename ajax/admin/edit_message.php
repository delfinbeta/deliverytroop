<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_comentario.php");
require_once("../../clases/clase_email.php");

// Objetos
$comentario = new Comentario($conexion);
$eemail = new Email();

$error = false;

// Recibir Datos
if(isset($_POST['id'])) { $id_comentario = $_POST['id']; } else { $id_comentario = 0; }
if(isset($_POST['respuesta'])) { $respuesta = $_POST['respuesta']; } else { $respuesta = ''; }

// Validaciones
if(!$error) {
	if($comentario->datos($id_comentario)) {
		$email = $comentario->email;
		$usuario = $comentario->nombre;

		if($comentario->responder($id_comentario, $respuesta)) {
			$eemail->enviar_respuesta_comentario($email, $usuario, $respuesta);
			echo json_encode(array("error" => false, "mensaje" => 'Comentario Respondido'));
		} else {
			echo json_encode(array("error" => true, "mensaje" => $comentario->error));
		}
	} else {
		echo json_encode(array("error" => true, "mensaje" => $comentario->error));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $comentario->error));
}
?>