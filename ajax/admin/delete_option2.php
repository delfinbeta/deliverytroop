<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_opcion2.php");

// Objetos
$opcion2 = new Opcion2($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_opcion2 = $_POST['id']; } else { $id_opcion2 = 0; }

if($opcion2->desactivar($id_opcion2)) {
	echo json_encode(array("error" => false, "mensaje" => 'Opcion2 Eliminado (D)'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $opcion2->error));
}
?>