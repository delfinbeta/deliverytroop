<?php
require("../configuracion/inicio.php");

if(isset($_POST['posicion'])) { $posicion = $_POST['posicion']; } else { $posicion = '---'; }

$pedido = array();

$pedido = $_SESSION['orden']['pedido'];  // Asignamos a la variable $carro los valores guardados en la sessión

unset($pedido[$posicion]);               // La función unset borra el elemento de un array que le pasemos por parámetro.
																	       // En este caso borramos el elemento cuyo id le pasemos a la página por la url

$_SESSION['orden']['pedido'] = $pedido;  // Actualizamos el arreglo carrito de compras en la sesión

echo json_encode(array("error" => false, "mensaje" => 'Eliminado del Carrito'));
?>