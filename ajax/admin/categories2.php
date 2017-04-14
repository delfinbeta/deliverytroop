<?php
require("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_categoria.php");

// Objetos
$categoria = new Categoria($conexion);

if(isset($_POST['tipo'])) { $tipo = $_POST['tipo']; } else { $tipo = 0; }

echo '<label for="categoria">Category:</label>';
echo '<select name="categoria" class="form-control">';
echo '<option value="0">Select Category</option>';

// Listar Categorias
$listado = $categoria->listado($tipo, 1);
$total = $categoria->total_listado($tipo, 1);

if($total > 0) {
	foreach($listado as $registro) {
		echo '<option value="'.$registro->obtener_id().'">'.$registro->nombre.'</option>';
	}
}

echo '</select>';
echo '<span id="bloqueErrorCategoria" class="help-block"></span>';
?>