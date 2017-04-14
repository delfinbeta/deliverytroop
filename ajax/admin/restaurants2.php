<?php
require("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_restaurante.php");

// Objetos
$restaurante = new Restaurante($conexion);

echo '<label for="restaurante">Restaurant:</label>';
echo '<select name="restaurante" class="form-control">';
echo '<option value="0">Select Restaurant</option>';

// Listar Categorias
$listado = $restaurante->listado(0, '', 1);
$total = $restaurante->total_listado(0, '', 1);

if($total > 0) {
	foreach($listado as $registro) {
		echo '<option value="'.$registro->obtener_id().'">'.$registro->nombre.'</option>';
	}
}

echo '</select>';
echo '<span id="bloqueErrorRestaurante" class="help-block"></span>';
?>