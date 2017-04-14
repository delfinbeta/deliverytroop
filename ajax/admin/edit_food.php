<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_producto.php");
require_once("../../clases/clase_restaurante.php");

// Objetos
$producto = new Producto($conexion);
$restaurante = new Restaurante($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_producto = $_POST['id']; } else { $id_producto = ''; }
if(isset($_POST['tipo'])) { $tipo = $_POST['tipo']; } else { $tipo = 0; }
if(isset($_POST['categoria'])) { $id_categoria = $_POST['categoria']; } else { $id_categoria = 0; }
if(isset($_POST['restaurante'])) { $id_restaurante = $_POST['restaurante']; } else { $id_restaurante = 0; }
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }
if(isset($_POST['resumen'])) { $resumen = $_POST['resumen']; } else { $resumen = ''; }
if(isset($_POST['descripcion'])) { $descripcion = $_POST['descripcion']; } else { $descripcion = ''; }
if(isset($_POST['recomendado'])) { $recomendado = $_POST['recomendado']; } else { $recomendado = 0; }

// Recibir archivo
$nombre_imagen = $_FILES['imagen']['name'];
$tipo_imagen = $_FILES['imagen']['type'];
$tamano_imagen = $_FILES['imagen']['size'];
$temporal_imagen = $_FILES['imagen']['tmp_name'];

$error = false;
$tamanoMAX = 10 * 1024 * 1024; // 10 MB
$tipos = array("jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "gif", "GIF");

// Validaciones
if($producto->datos($id_producto)) {
	if($nombre_imagen == "") { $nombre_imagen = $producto->imagen; }
	else {
	  $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

	  if(!in_array($extension, $tipos, true)) {  // Permitir subir solo los tipos de imagen permitidos,
	    $error = true;
	    $producto->error = "Tipo de Archivo no permitido (".$extension.")";
	  }
	  
	  if($tamano_imagen > $tamanoMAX) {  // Solo imagenes menores al tamaño máximo definido
	    $error = true;
	    $producto->error = "Archivo no puede ser superior a 10MB";
	  }
	  
	  if(!$error) {
	    // Nombre Archivo Imagen
	    $cont = 1;
	    $cola = -1 - strlen($extension);
	    $nomb_img = substr($nombre_imagen, 0, $cola);
	    while($producto->imagen_existe($nombre_imagen, $id_producto)) {
	      $nombre_imagen = $nomb_img.'-'.$cont.'.'.$extension;
	      $cont++;
	    }

	    if(!$producto->cargar_archivo($nombre_imagen, $temporal_imagen)) { $error = true; }  // No cargo el archivo imagen
	  }
	}
} else {
	$error = true;
}

if($restaurante->datos($id_restaurante)) { $id_categoria = $restaurante->obtener_categoria(); }

if(!$error) {
	if($producto->actualizar($id_producto, $tipo, $id_categoria, $id_restaurante, $nombre, $resumen, $descripcion, $recomendado, $nombre_imagen)) {
		echo json_encode(array("error" => false, "mensaje" => 'Producto Actualizado'));
	} else {
		echo json_encode(array("error" => true, "mensaje" => $producto->error));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $producto->error));
}
?>