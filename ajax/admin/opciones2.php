<?php
require("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_opcion2.php");

// Objetos
$opcion2 = new Opcion2($conexion);

echo '<select name="opcion2[]" class="form-control">';
echo '<option value="0">Select</option>';

// Listar Opciones 2
$listado = $opcion2->listado(1);
$total = $opcion2->total_listado(1);

if($total > 0) {
	foreach($listado as $reg_op2) {
		echo '<option value="'.$reg_op2->obtener_id().'">'.$reg_op2->nombre.'</option>';
	}
}

echo '</select>';
?>