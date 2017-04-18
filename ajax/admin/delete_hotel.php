<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_hotel.php");

// Objetos
$hotel = new Hotel($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_hotel = $_POST['id']; } else { $id_hotel = 0; }

if($hotel->desactivar($id_hotel)) {
	echo json_encode(array("error" => false, "mensaje" => 'Hotel Eliminado (D)'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $hotel->error));
}
?>