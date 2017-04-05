<?php
require("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_usuario.php");

// Objetos
$usuario = new Usuario($conexion);

// Recibir Datos
if(isset($_POST['usuario'])) { $nusuario = $_POST['usuario']; } else { $nusuario = ''; }
if(isset($_POST['contrasena'])) { $contrasena = $_POST['contrasena']; } else { $contrasena = ''; }

if($usuario->autenticar($nusuario, $contrasena)) {
	echo json_encode(array("error" => false, "mensaje" => 'Usuario Entró'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $usuario->error));
}
?>