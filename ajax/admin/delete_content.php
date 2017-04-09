<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_contenido.php");

// Objetos
$contenido = new Contenido($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_contenido = $_POST['id']; } else { $id_contenido = 0; }

if($contenido->desactivar($id_contenido)) {
	echo json_encode(array("error" => false, "mensaje" => 'Contenido Eliminado (D)'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $contenido->error));
}
?>