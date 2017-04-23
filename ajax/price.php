<?php
require("../configuracion/inicio.php");

// Clases
require("../clases/clase_presentacion.php");

// Objetos
$presentacion = new Presentacion($conexion);

// Recibir Datos
if(isset($_POST['producto'])) { $id_producto = $_POST['producto']; } else { $id_producto = 0; }
if(isset($_POST['opcion1'])) { $id_opcion1 = $_POST['opcion1']; } else { $id_opcion1 = 0; }
if(isset($_POST['opcion2'])) { $id_opcion2 = $_POST['opcion2']; } else { $id_opcion2 = 0; }

if($presentacion->datos($id_producto, $id_opcion1, $id_opcion2)) {
	$precio = $presentacion->precio;
} else {
	$precio = "---";
}

echo $precio;
?>