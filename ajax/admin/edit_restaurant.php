<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_restaurante.php");

// Objetos
$restaurante = new Restaurante($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_restaurante = $_POST['id']; } else { $id_restaurante = ''; }
if(isset($_POST['categoria'])) { $id_categoria = $_POST['categoria']; } else { $id_categoria = 0; }
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }
if(isset($_POST['zipcode'])) { $zipcode = $_POST['zipcode']; } else { $zipcode = ''; }
if(isset($_POST['direccion'])) { $direccion = $_POST['direccion']; } else { $direccion = ''; }
if(isset($_POST['hora_inicio'])) { $hora_inicio = date("H:i", strtotime($_POST['hora_inicio'])); } else { $hora_inicio = '00:00'; }
if(isset($_POST['hora_fin'])) { $hora_fin = date("H:i", strtotime($_POST['hora_fin'])); } else { $hora_fin = '00:00'; }

// Recibir archivo
$nombre_imagen = $_FILES['imagen']['name'];
$tipo_imagen = $_FILES['imagen']['type'];
$tamano_imagen = $_FILES['imagen']['size'];
$temporal_imagen = $_FILES['imagen']['tmp_name'];

$error = false;
$tamanoMAX = 10 * 1024 * 1024; // 10 MB
$tipos = array("jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "gif", "GIF");

// Validaciones
if($restaurante->datos($id_restaurante)) {
	if($nombre_imagen == "") { $nombre_imagen = $restaurante->imagen; }
	else {
	  $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

	  if(!in_array($extension, $tipos, true)) {  // Permitir subir solo los tipos de imagen permitidos,
	    $error = true;
	    $restaurante->error = "Tipo de Archivo no permitido (".$extension.")";
	  }
	  
	  if($tamano_imagen > $tamanoMAX) {  // Solo imagenes menores al tamaño máximo definido
	    $error = true;
	    $restaurante->error = "Archivo no puede ser superior a 10MB";
	  }
	  
	  if(!$error) {
	    // Nombre Archivo Imagen
	    $cont = 1;
	    $cola = -1 - strlen($extension);
	    $nomb_img = substr($nombre_imagen, 0, $cola);
	    while($restaurante->imagen_existe($nombre_imagen, $id_restaurante)) {
	      $nombre_imagen = $nomb_img.'-'.$cont.'.'.$extension;
	      $cont++;
	    }

	    if(!$restaurante->cargar_archivo($nombre_imagen, $temporal_imagen)) { $error = true; }  // No cargo el archivo imagen
	  }
	}
} else {
	$error = true;
}

if(!$error) {
	if($restaurante->actualizar($id_restaurante, $id_categoria, $nombre, $zipcode, $direccion, $hora_inicio, $hora_fin, $nombre_imagen)) {
		echo json_encode(array("error" => false, "mensaje" => 'Restaurante Actualizado'));
	} else {
		echo json_encode(array("error" => true, "mensaje" => $restaurante->error));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $restaurante->error));
}
?>