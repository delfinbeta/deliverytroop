<?php
// Verificar inicio sesion
if(!$_SESSION['autorizado']) {
  $_SESSION['error'] = 1;
  header("location: ".$GLOBALS['domain_root']."/administracion/error_sesion.php");
}

// Verificar tiempo de sesion
$tiempo_sesion = time() - $_SESSION['usuario_tiempo'];
if($tiempo_sesion > $TIEMPO_MAXIMO_SESION) {
  $_SESSION['error'] = 2;
  header("location: ".$GLOBALS['domain_root']."/administracion/error_sesion.php");
} else {
  $_SESSION['usuario_tiempo'] = time();
}
?>