<?php
require("../configuracion/inicio.php");

// Clases
require("../clases/clase_orden.php");
require("../clases/clase_orden_presentacion.php");
require("../clases/clase_general.php");
require_once("../stripe-php-3.23.0/init.php");

// Objetos
$orden = new Orden($conexion);
$orden_presentacion = new OrdenPresentacion($conexion);
$general = new General($conexion);

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_mfCEU4TEqRfDvYroVDCftm1M");

// Get the credit card details submitted by the form
if(isset($_POST['stripeToken'])) { $token = $_POST['stripeToken']; } else { $token = '---'; }

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

	// Preparar Nueva compra
	session_start();
	$_SESSION['orden'] = array('nombre' => '', 'email' => '', 'telefono' => '', 'direccion' => '', 'zipcode' => $zipcode, 'ciudad' => '', 'hotel_id' => 0, 'hotel_nombre' => '', 'habitacion' => '', 'instrucciones' => '');

	$centavos = intval($total * 100);

	// Create a charge: this will charge the user's card
  try {
    $charge = \Stripe\Charge::create(array(
      "amount" => $centavos, // Amount in cents
      "currency" => "usd",
      "source" => $token,
      "description" => "Orden #".$id_orden,
      "metadata" => array("order_id" => $id_orden)
    ));
    $orden->actualizar_estado($id_orden, 2);
  } catch(\Stripe\Error\Card $e) {
    // The card has been declined
    $orden->actualizar_estado($id_orden, 3);
  }

	$url = '?msjError=E';
} else {
	$url = '?msjError='.$orden->error;
}

header('location: ../order.php'.$url);
?>