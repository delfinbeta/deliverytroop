<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_presentacion.php");

// Objetos
$presentacion = new Presentacion($conexion);

$error = false;

// Recibir Datos
if(isset($_POST['producto'])) { $id_producto = $_POST['producto']; } else { $id_producto = 0; }

// Listar Presentaciones
$listado_presentaciones = $presentacion->listado($id_producto, 0, 0);
$total_presentaciones = $presentacion->total_listado($id_producto, 0, 0);

if($total_presentaciones > 0) {
	foreach($listado_presentaciones as $reg_presentacion) {
		$presentacion->eliminar($id_producto, $reg_presentacion->obtener_opcion1(), $reg_presentacion->obtener_opcion2());
	}
}

if(isset($_POST['opcion1'])) {
	$i = 0;
	$opciones1 = $_POST['opcion1'];
	$opciones2 = $_POST['opcion2'];
	$precios = $_POST['precio'];
	foreach($opciones1 as $reg_opc1) {
		if($precios[$i] == '') { $precios[$i] = 0; }
		$presentacion->insertar($id_producto, $reg_opc1, $opciones2[$i], $precios[$i]);
		$i++;
	}
}

echo json_encode(array("error" => false, "mensaje" => 'Presentacion Atualizado'));
?>