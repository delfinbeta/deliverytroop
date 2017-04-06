<?php
require_once("../../configuracion/inicio_admin.php");

// Clases
require_once("../../clases/clase_usuario.php");

// Objetos
$usuario = new Usuario($conexion);

// Recibir Datos
if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; } else { $nombre = ''; }
if(isset($_POST['apellido'])) { $apellido = $_POST['apellido']; } else { $apellido = ''; }
if(isset($_POST['email'])) { $email = $_POST['email']; } else { $email = ''; }
if(isset($_POST['sexo'])) { $sexo = $_POST['sexo']; } else { $sexo = 0; }

// Recibir archivo
$nombre_foto = $_FILES['foto']['name'];
$tipo_foto = $_FILES['foto']['type'];
$tamano_foto = $_FILES['foto']['size'];
$temporal_foto = $_FILES['foto']['tmp_name'];

$error = false;
$tamanoMAX = 10 * 1024 * 1024; // 10 MB
$tipos = array("jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "gif", "GIF");

// Validaciones
if($nombre_foto == "") { $nombre_foto = $_SESSION['usuario_foto']; }
else {
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
    while($usuario->foto_existe($nombre_foto, $_SESSION['usuario_id'])) {
      $nombre_foto = $nomb_img.'-'.$cont.'.'.$extension;
      $cont++;
    }

    if(!$usuario->cargar_archivo($nombre_foto, $temporal_foto)) { $error = true; }  // No cargo el archivo imagen
  }
}

if(!$error) {
	if(!$usuario->email_existe($email, $_SESSION['usuario_id'])) {
		if($usuario->actualizar($_SESSION['usuario_id'], $nombre, $apellido, $email, $nombre_foto, $sexo, $_SESSION['usuario_tipo'])) {
			$_SESSION['usuario_nombre'] = $nombre;
			$_SESSION['usuario_apellido'] = $apellido;
			$_SESSION['usuario_email'] = $email;
			$_SESSION['usuario_sexo'] = $sexo;
			$_SESSION['usuario_foto'] = $nombre_foto;

      switch($sexo) {
        case 1: $_SESSION['usuario_csexo'] = "Femenino"; break;
        case 2: $_SESSION['usuario_csexo'] = "Masculino"; break;
        case 3: $_SESSION['usuario_csexo'] = "Otro"; break;
        default: $_SESSION['usuario_csexo'] = "---"; break;
      }

      if($nombre_foto == '') {
        if($sexo == 1) {
          $_SESSION['usuario_rutafoto'] = $GLOBALS['domain_root']."/img/usuario_mujer.jpg";
        } else {
          $_SESSION['usuario_rutafoto'] = $GLOBALS['domain_root']."/img/usuario_hombre.jpg";
        }
        
      } else {
        $_SESSION['usuario_rutafoto'] = $GLOBALS['domain_root']."/archivos_usuarios/".$nombre_foto;
      }
      
      $foto = '<img class="img-responsive avatar-view" src="'.$_SESSION['usuario_rutafoto'].'" alt="'.$nombre.' '.$apellido.'" title="'.$nombre.' '.$apellido.'" />';

			echo json_encode(array("error" => false, "mensaje" => 'Perfil Atualizado', "foto" => $foto));
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