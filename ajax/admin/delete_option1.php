<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_opcion1.php");

// Objetos
$opcion1 = new Opcion1($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_opcion1 = $_POST['id']; } else { $id_opcion1 = 0; }

if($opcion1->desactivar($id_opcion1)) {
	echo json_encode(array("error" => false, "mensaje" => 'Opcion1 Eliminado (D)'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $opcion1->error));
}
?>