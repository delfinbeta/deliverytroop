<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_comentario.php");

// Objetos
$comentario = new Comentario($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_comentario = $_POST['id']; } else { $id_comentario = 0; }

if($comentario->desactivar($id_comentario)) {
	echo json_encode(array("error" => false, "mensaje" => 'Comentario Eliminado (D)'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $comentario->error));
}
?>