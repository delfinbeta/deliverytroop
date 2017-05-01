<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_orden.php");

// Objetos
$orden = new Orden($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_orden = $_POST['id']; } else { $id_orden = 0; }
if(isset($_POST['estado'])) { $estado = $_POST['estado']; } else { $estado = 0; }

if($orden->actualizar_estado($id_orden, $estado)) {
	echo json_encode(array("error" => false, "mensaje" => 'Orden Estatus'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $orden->error));
}
?>