<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_usuario.php");

// Objetos
$usuario = new Usuario($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_usuario = $_POST['id']; } else { $id_usuario = 0; }

if($usuario->desactivar($id_usuario)) {
	echo json_encode(array("error" => false, "mensaje" => 'Usuario Eliminado (D)'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $usuario->error));
}
?>