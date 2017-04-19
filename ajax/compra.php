<?php
require("../configuracion/inicio.php");

// Clases
require("../clases/clase_zipcode.php");

// Objetos
$zipcode = new Zipcode($conexion);

// Recibir Datos
if(isset($_POST['zipcode'])) { $_SESSION['orden']['zipcode'] = $_POST['zipcode']; }
if(isset($_POST['direccion'])) { $_SESSION['orden']['direccion'] = $_POST['direccion']; }

if($zipcode->datos2($_SESSION['orden']['zipcode'])) {
	echo json_encode(array("error" => false, "mensaje" => 'Zipcode Aceptado'));
} else {
	echo json_encode(array("error" => true, "mensaje" => "Sorry, it looks like we're not in your area yet"));
}
?>