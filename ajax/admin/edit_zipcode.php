<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_zipcode.php");

// Objetos
$zipcode = new Zipcode($conexion);

$error = false;

// Recibir Datos
if(isset($_POST['id'])) { $id_zipcode = $_POST['id']; } else { $id_zipcode = 0; }
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }
if(isset($_POST['codigo'])) { $codigo = $_POST['codigo']; } else { $codigo = ''; }

// Validaciones
if($zipcode->datos($id_zipcode)) {
  if(!$error) {
		if($zipcode->actualizar($id_zipcode, $nombre, $codigo)) {
			echo json_encode(array("error" => false, "mensaje" => 'Zipcode Atualizado'));
		} else {
			echo json_encode(array("error" => true, "mensaje" => $zipcode->error));
		}
  } else {
  	echo json_encode(array("error" => true, "mensaje" => $zipcode->error));
  }
} else {
  echo json_encode(array("error" => true, "mensaje" => $zipcode->error));
}
?>