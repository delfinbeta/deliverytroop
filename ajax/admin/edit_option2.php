<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_opcion2.php");

// Objetos
$opcion2 = new Opcion2($conexion);

$error = false;

// Recibir Datos
if(isset($_POST['id'])) { $id_opcion2 = $_POST['id']; } else { $id_opcion2 = 0; }
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }

// Validaciones
if($opcion2->datos($id_opcion2)) {
  if(!$error) {
		if($opcion2->actualizar($id_opcion2, $nombre)) {
			echo json_encode(array("error" => false, "mensaje" => 'Opcion2 Atualizado'));
		} else {
			echo json_encode(array("error" => true, "mensaje" => $opcion2->error));
		}
  } else {
  	echo json_encode(array("error" => true, "mensaje" => $opcion2->error));
  }
} else {
  echo json_encode(array("error" => true, "mensaje" => $opcion2->error));
}
?>