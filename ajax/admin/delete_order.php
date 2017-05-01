<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_orden.php");

// Objetos
$orden = new Orden($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_orden = $_POST['id']; } else { $id_orden = 0; }

if($orden->desactivar($id_orden)) {
	echo json_encode(array("error" => false, "mensaje" => 'Orden Eliminado (D)'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $orden->error));
}
?>