<?php
require("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_opcion1.php");

// Objetos
$opcion1 = new Opcion1($conexion);

echo '<select name="opcion1[]" class="form-control">';
echo '<option value="0">Select</option>';

// Listar Opciones 1
$listado = $opcion1->listado(1);
$total = $opcion1->total_listado(1);

if($total > 0) {
	foreach($listado as $reg_op1) {
		echo '<option value="'.$reg_op1->obtener_id().'">'.$reg_op1->nombre.'</option>';
	}
}

echo '</select>';
?>