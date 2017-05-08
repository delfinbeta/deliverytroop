<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_orden.php");
require_once("../../clases/clase_email.php");

// Objetos
$orden = new Orden($conexion);
$eemail = new Email();

// Recibir Datos
if(isset($_POST['id'])) { $id_orden = $_POST['id']; } else { $id_orden = 0; }
if(isset($_POST['estado'])) { $estado = $_POST['estado']; } else { $estado = 0; }

if($orden->actualizar_estado($id_orden, $estado)) {
	if($orden->datos($id_orden)) {
		$usuario = $orden->nombre;
		$email = $orden->email;
		$status = $orden->obtener_estado();
	} else {
		$usuario = '---';
		$email = 'deliverytroop@gmail.com';
		$status = '---';
	}

	$eemail->enviar_orden_status($email, $usuario, $id_orden, $status);

	echo json_encode(array("error" => false, "mensaje" => 'Orden Estatus'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $orden->error));
}
?>