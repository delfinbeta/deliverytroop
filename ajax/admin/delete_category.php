<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_categoria.php");

// Objetos
$categoria = new Categoria($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_categoria = $_POST['id']; } else { $id_categoria = 0; }

if($categoria->desactivar($id_categoria)) {
	echo json_encode(array("error" => false, "mensaje" => 'Categoria Eliminado (D)'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $categoria->error));
}
?>