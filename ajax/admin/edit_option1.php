<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_opcion1.php");

// Objetos
$opcion1 = new Opcion1($conexion);

$error = false;

// Recibir Datos
if(isset($_POST['id'])) { $id_opcion1 = $_POST['id']; } else { $id_opcion1 = 0; }
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }

// Validaciones
if($opcion1->datos($id_opcion1)) {
  if(!$error) {
		if($opcion1->actualizar($id_opcion1, $nombre)) {
			echo json_encode(array("error" => false, "mensaje" => 'Opcion1 Atualizado'));
		} else {
			echo json_encode(array("error" => true, "mensaje" => $opcion1->error));
		}
  } else {
  	echo json_encode(array("error" => true, "mensaje" => $opcion1->error));
  }
} else {
  echo json_encode(array("error" => true, "mensaje" => $opcion1->error));
}
?>