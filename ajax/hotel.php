<?php
require("../configuracion/inicio.php");

// Clases
require("../clases/clase_hotel.php");

// Objetos
$hotel = new Hotel($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_hotel = $_POST['id']; }

if($hotel->datos($id_hotel)) {
	$_SESSION['orden']['hotel_id'] = $id_hotel;
	$_SESSION['orden']['hotel_nombre'] = $hotel->nombre;
	$_SESSION['orden']['direccion'] = $hotel->direccion;

	echo json_encode(array("error" => false, "mensaje" => 'Hotel Aceptado'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $hotel->error));
}
?>