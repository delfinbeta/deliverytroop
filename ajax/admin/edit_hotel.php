<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_hotel.php");

// Objetos
$hotel = new Hotel($conexion);

// Recibir Datos
if(isset($_POST['id'])) { $id_hotel = $_POST['id']; } else { $id_hotel = ''; }
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }
if(isset($_POST['zipcode'])) { $zipcode = $_POST['zipcode']; } else { $zipcode = ''; }
if(isset($_POST['ciudad'])) { $ciudad = $_POST['ciudad']; } else { $ciudad = ''; }
if(isset($_POST['direccion'])) { $direccion = $_POST['direccion']; } else { $direccion = ''; }

// Recibir archivo
$nombre_imagen = $_FILES['imagen']['name'];
$tipo_imagen = $_FILES['imagen']['type'];
$tamano_imagen = $_FILES['imagen']['size'];
$temporal_imagen = $_FILES['imagen']['tmp_name'];

$error = false;
$tamanoMAX = 10 * 1024 * 1024; // 10 MB
$tipos = array("jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "gif", "GIF");

// Validaciones
if($hotel->datos($id_hotel)) {
	if($nombre_imagen == "") { $nombre_imagen = $hotel->imagen; }
	else {
	  $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

	  if(!in_array($extension, $tipos, true)) {  // Permitir subir solo los tipos de imagen permitidos,
	    $error = true;
	    $hotel->error = "Tipo de Archivo no permitido (".$extension.")";
	  }
	  
	  if($tamano_imagen > $tamanoMAX) {  // Solo imagenes menores al tamaño máximo definido
	    $error = true;
	    $hotel->error = "Archivo no puede ser superior a 10MB";
	  }
	  
	  if(!$error) {
	    // Nombre Archivo Imagen
	    $cont = 1;
	    $cola = -1 - strlen($extension);
	    $nomb_img = substr($nombre_imagen, 0, $cola);
	    while($hotel->imagen_existe($nombre_imagen, $id_hotel)) {
	      $nombre_imagen = $nomb_img.'-'.$cont.'.'.$extension;
	      $cont++;
	    }

	    if(!$hotel->cargar_archivo($nombre_imagen, $temporal_imagen)) { $error = true; }  // No cargo el archivo imagen
	  }
	}
} else {
	$error = true;
}

if(!$error) {
	if($hotel->actualizar($id_hotel, $nombre, $zipcode, $ciudad, $direccion, $nombre_imagen)) {
		echo json_encode(array("error" => false, "mensaje" => 'Restaurante Actualizado'));
	} else {
		echo json_encode(array("error" => true, "mensaje" => $hotel->error));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $hotel->error));
}
?>