<?php
require("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_usuario.php");
require_once("../../clases/clase_email.php");
require_once("../../clases/clase_general.php");

// Objetos
$usuario = new Usuario($conexion);
$eemail = new Email();
$general = new General($conexion);

// Recibir Datos
if(isset($_POST['email'])) { $email = $_POST['email']; } else { $email = ''; }

if($usuario->email_existe($email, 0)) {
	$nueva_contrasena = $general->generarCodigo(10, true, true, false);

	if($usuario->recuperar_contrasena($email, $nueva_contrasena)) {
		$eemail->enviar_contrasena($email, $nueva_contrasena, $usuario->nombre, $usuario->apellido);
		echo json_encode(array("error" => false, "mensaje" => 'Contraseña recuperada'));
	} else {
		echo json_encode(array("error" => true, "mensaje" => $usuario->error));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => "Wrong email"));
}
?>