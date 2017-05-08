<?php
require("../configuracion/inicio.php");

// Clases
require("../clases/clase_orden.php");
require("../clases/clase_orden_presentacion.php");
require("../clases/clase_producto.php");
require("../clases/clase_opcion1.php");
require("../clases/clase_opcion2.php");
require("../clases/clase_general.php");
require("../clases/clase_email.php");
require_once("../stripe-php-3.23.0/init.php");

// Objetos
$orden = new Orden($conexion);
$orden_presentacion = new OrdenPresentacion($conexion);
$producto = new Producto($conexion);
$opcion1 = new Opcion1($conexion);
$opcion2 = new Opcion2($conexion);
$general = new General($conexion);
$eemail = new Email();

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

	$html_carrito = '';
	$html_carrito .= '<table width="100%" style="color: #666666; font-family: Arial; font-size: 12px; line-height: 18px;">';
	$html_carrito .= '<thead>';
	$html_carrito .= '<tr>';
	$html_carrito .= '<th style="background-color: #F5F5F5;">Item</th>';
	$html_carrito .= '<th style="background-color: #F5F5F5;">Option 1</th>';
	$html_carrito .= '<th style="background-color: #F5F5F5;">Option 2</th>';
	$html_carrito .= '<th style="background-color: #F5F5F5; text-align: right;">Qty</th>';
	$html_carrito .= '<th style="background-color: #F5F5F5; text-align: right;">Price</th>';
	$html_carrito .= '<th style="background-color: #F5F5F5; text-align: right;">Subtotal</th>';
	$html_carrito .= '</tr>';
	$html_carrito .= '</thead>';
	$html_carrito .= '<tbody>';

	$subtotal1 = 0;
	$subtotal2 = 0;
	foreach($pedido as $item) {
		$orden_presentacion->insertar($id_orden, $item['producto'], $item['opcion1'], $item['opcion2'], $item['precio'], $item['cantidad'], $item['instrucciones']);

		if($producto->datos($item['producto'])) { $producto_nombre = $producto->nombre; } else { $producto_nombre = '---'; }
		if($opcion1->datos($item['opcion1'])) { $opcion1_nombre = $opcion1->nombre; } else { $opcion1_nombre = '---'; }
		if($opcion2->datos($item['opcion2'])) { $opcion2_nombre = $opcion2->nombre; } else { $opcion2_nombre = '---'; }

		$subtotal1 = $item['cantidad'] * $item['precio'];
		$subtotal2 += $subtotal1;

		$html_carrito .= '<tr>';
		$html_carrito .= '<td>'.$producto_nombre.'</td>';
		$html_carrito .= '<td>'.$opcion1_nombre.'</td>';
		$html_carrito .= '<td>'.$opcion2_nombre.'</td>';
		$html_carrito .= '<td style="text-align: right;">'.$item['cantidad'].'</td>';
		$html_carrito .= '<td style="text-align: right;">$'.$item['precio'].'</td>';
		$html_carrito .= '<td style="text-align: right;">$'.number_format($subtotal1, 2).'</td>';
		$html_carrito .= '</tr>';
	}

	$html_carrito .= '<tr>';
	$html_carrito .= '<td colspan="5" style="background-color: #F5F5F5; text-align: right;"><strong>Subtotal</strong></td>';
	$html_carrito .= '<td style="background-color: #F5F5F5; text-align: right;">'.number_format($subtotal2, 2).'</td>';
	$html_carrito .= '</tr>';
	$html_carrito .= '<tr>';
	$html_carrito .= '<td colspan="5" style="background-color: #F5F5F5; text-align: right;"><strong>Delivery Fee</strong></td>';
	$html_carrito .= '<td style="background-color: #F5F5F5; text-align: right;">'.number_format($delivery, 2).'</td>';
	$html_carrito .= '</tr>';
	$html_carrito .= '<tr>';
	$html_carrito .= '<td colspan="5" style="background-color: #F5F5F5; text-align: right;"><strong>Tax</strong></td>';
	$html_carrito .= '<td style="background-color: #F5F5F5; text-align: right;">'.number_format($tax, 2).'</td>';
	$html_carrito .= '</tr>';
	$html_carrito .= '<tr>';
	$html_carrito .= '<td colspan="5" style="background-color: #F5F5F5; text-align: right;"><strong>Tip</strong></td>';
	$html_carrito .= '<td style="background-color: #F5F5F5; text-align: right;">'.number_format($propina, 2).'</td>';
	$html_carrito .= '</tr>';
	$html_carrito .= '<tr>';
	$html_carrito .= '<td colspan="5" style="background-color: #F5F5F5; text-align: right;"><strong>Total</strong></td>';
	$html_carrito .= '<td style="background-color: #F5F5F5; text-align: right;">'.number_format($total, 2).'</td>';
	$html_carrito .= '</tr>';
	$html_carrito .= '</tbody>';
	$html_carrito .= '<table>';

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

  // Enviar email
  $eemail->enviar_orden($id_orden, $nombre, $email, $telefono, $direccion, $zipcode, $ciudad, $id_hotel, $hotel_nombre, $habitacion, $instrucciones, $html_carrito);

	$url = '?msjError=E';
} else {
	$url = '?msjError='.$orden->error;
}

header('location: ../order.php'.$url);
?>