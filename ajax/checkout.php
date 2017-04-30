<?php
require("../configuracion/inicio.php");

// Clases
require("../clases/clase_orden.php");
require("../clases/clase_orden_presentacion.php");
require("../clases/clase_general.php");

// Objetos
$orden = new Orden($conexion);
$orden_presentacion = new OrdenPresentacion($conexion);
$general = new General($conexion);

// Recibir Datos
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = '---'; }
if(isset($_POST['email'])) { $email = $_POST['email']; } else { $email = '---'; }
if(isset($_POST['telefono'])) { $telefono = $_POST['telefono']; } else { $telefono = '---'; }
if(isset($_POST['direccion'])) { $direccion = $_POST['direccion']; } else { $direccion = '---'; }
if(isset($_POST['zipcode'])) { $zipcode = $_POST['zipcode']; } else { $zipcode = '---'; }
if(isset($_POST['ciudad'])) { $ciudad = $_POST['ciudad']; } else { $ciudad = '---'; }
if(isset($_POST['hotel_id'])) { $id_hotel = $_POST['hotel_id']; } else { $id_hotel = 0; }
if(isset($_POST['hotel_nombre'])) { $hotel_nombre = $_POST['hotel_nombre']; } else { $hotel_nombre = '---'; }
if(isset($_POST['habitacion'])) { $habitacion = $_POST['habitacion']; } else { $habitacion = '---'; }
if(isset($_POST['instrucciones'])) { $instrucciones = $_POST['instrucciones']; } else { $instrucciones = '---'; }
if(isset($_POST['delivery'])) { $delivery = $_POST['delivery']; } else { $delivery = 0; }
if(isset($_POST['tax'])) { $tax = $_POST['tax']; } else { $tax = 0; }
if(isset($_POST['propina'])) { $propina = $_POST['propina']; } else { $propina = 0; }
if(isset($_POST['total'])) { $total = $_POST['total']; } else { $total = 0; }

$pedido = $_SESSION['orden']['pedido'];

if($orden->insertar($nombre, $email, $telefono, $direccion, $zipcode, $ciudad, $instrucciones, $id_hotel, $hotel_nombre, $habitacion, $delivery, $tax, $propina, $total)) {
	$id_orden = $general->ultimo_id($conexion);

	foreach($pedido as $item) {
		$orden_presentacion->insertar($id_orden, $item['producto'], $item['opcion1'], $item['opcion2'], $item['precio'], $item['cantidad'], $item['instrucciones']);
	}

	session_unset();                 // Vacia las variables de sesion
	session_destroy();               // Destruye la sesion

	echo json_encode(array("error" => false, "mensaje" => 'Checkout Correcto'));
} else {
	echo json_encode(array("error" => true, "mensaje" => $orden->error));
}
?>