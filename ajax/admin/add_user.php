<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_usuario.php");

// Objetos
$usuario = new Usuario($conexion);

// Recibir Datos
if(isset($_POST['usuario'])) { $nusuario = $_POST['usuario']; } else { $nusuario = ''; }
if(isset($_POST['contrasena'])) { $contrasena = $_POST['contrasena']; } else { $contrasena = ''; }
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }
if(isset($_POST['apellido'])) { $apellido = $_POST['apellido']; } else { $apellido = ''; }
if(isset($_POST['email'])) { $email = $_POST['email']; } else { $email = ''; }
if(isset($_POST['sexo'])) { $sexo = $_POST['sexo']; } else { $sexo = 0; }
$tipo = 1;

// Recibir archivo
$nombre_foto = $_FILES['foto']['name'];
$tipo_foto = $_FILES['foto']['type'];
$tamano_foto = $_FILES['foto']['size'];
$temporal_foto = $_FILES['foto']['tmp_name'];

$error = false;
$tamanoMAX = 10 * 1024 * 1024; // 10 MB
$tipos = array("jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "gif", "GIF");

// Validaciones
if(!$nombre_foto == "") {
  $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

  if(!in_array($extension, $tipos, true)) {  // Permitir subir solo los tipos de imagen permitidos,
    $error = true;
    $usuario->error = "Tipo de Archivo no permitido (".$extension.")";
  }
  
  if($tamano_foto > $tamanoMAX) {  // Solo imagenes menores al tamaño máximo definido
    $error = true;
    $usuario->error = "Archivo no puede ser superior a 10MB";
  }
  
  if(!$error) {
    // Nombre Archivo Imagen
    $cont = 1;
    $cola = -1 - strlen($extension);
    $nomb_img = substr($nombre_foto, 0, $cola);
    while($usuario->foto_existe($nombre_foto, 0)) {
      $nombre_foto = $nomb_img.'-'.$cont.'.'.$extension;
      $cont++;
    }

    if(!$usuario->cargar_archivo($nombre_foto, $temporal_foto)) { $error = true; }  // No cargo el archivo imagen
  }
}

if(!$error) {
	if(!$usuario->email_existe($email, 0)) {
		if($usuario->insertar($nusuario, $contrasena, $nombre, $apellido, $email, $nombre_foto, $sexo, $tipo)) {
			echo json_encode(array("error" => false, "mensaje" => 'Usuario Agregado'));
		} else {
			echo json_encode(array("error" => true, "mensaje" => $usuario->error));
		}
	} else {
		echo json_encode(array("error" => true, "mensaje" => "El Email ya se encuentra registrado"));
	}
} else {
	echo json_encode(array("error" => true, "mensaje" => $usuario->error));
}
?>