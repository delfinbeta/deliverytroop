<?php
require("../configuracion/inicio.php");

// Clases
require("../clases/clase_producto.php");
require("../clases/clase_presentacion.php");
require("../clases/clase_opcion1.php");
require("../clases/clase_opcion2.php");

// Objetos
$producto = new Producto($conexion);
$presentacion = new Presentacion($conexion);
$opcion1 = new Opcion1($conexion);
$opcion2 = new Opcion2($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_producto = $_POST['id']; } else { $id_producto = 0; }

if($producto->datos($id_producto)) {
	// Listar Opsiones 1
	$listado_opciones1 = $presentacion->opciones1($id_producto);
	$total_opciones1 = count($listado_opciones1);
	if($total_opciones1 > 1) {
		$selects1 = '<label for="opcion1" class="control-label">Option 1:</label>';
		$selects1 .= '<select id="opcion1" name="opcion1" class="form-control">';
		foreach($listado_opciones1 as $reg_opc1) {
			if($opcion1->datos($reg_opc1)) { $nombre_opcion1 = $opcion1->nombre; } else { $nombre_opcion1 = '---'; }
			$selects1 .= '<option value="'.$reg_opc1.'">'.$nombre_opcion1.'</option>';
		}
		$selects1 .= '</select>';
		$id_opcion1 = $listado_opciones1[0];
	} else {
		if($total_opciones1 > 0) {
			$selects1 = '';
			$id_opcion1 = $listado_opciones1[0];
		} else {
			$selects1 = '';
			$id_opcion1 = 0;
		}
	}

	// Listar Opsiones 2
	$listado_opciones2 = $presentacion->opciones2($id_producto);
	$total_opciones2 = count($listado_opciones2);
	if($total_opciones2 > 1) {
		$selects2 = '<label for="opcion2" class="control-label">Option 2:</label>';
		$selects2 .= '<select id="opcion2" name="opcion2" class="form-control">';
		foreach($listado_opciones2 as $reg_opc2) {
			if($opcion2->datos($reg_opc2)) { $nombre_opcion2 = $opcion2->nombre; } else { $nombre_opcion2 = '---'; }
			$selects2 .= '<option value="'.$reg_opc2.'">'.$nombre_opcion2.'</option>';
		}
		$selects2 .= '</select>';
		$id_opcion2 = $listado_opciones2[0];
	} else {
		if($total_opciones2 > 0) {
			$selects2 = '';
			$id_opcion2 = $listado_opciones2[0];
		} else {
			$selects2 = '';
			$id_opcion2 = 0;
		}
	}

	if($presentacion->datos($id_producto, $id_opcion1, $id_opcion2)) {
		$precio = $presentacion->precio;
	} else {
		$precio = "---";
	}

	echo json_encode(array("error" => false, "mensaje" => 'Producto Consultado', "nombre" => $producto->nombre, "selects1" => $selects1, "selects2" => $selects2, "opc1" => $id_opcion1, "opc2" => $id_opcion2, "precio" => $precio));
} else {
	echo json_encode(array("error" => true, "mensaje" => $producto->error));
}
?>