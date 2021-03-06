<?php
class Usuario extends Seguridad {
	########################################  Atributos  ########################################
	
	private $id;
	private $usuario;
	private $contrasena;
	public  $nombre;
	public  $apellido;
	public  $email;
	public  $foto;
	private $sexo;
	private $tipo;
	private $estado;
	private $fecha_registro;
	private $usuario_registro;
	private $fecha_actualizacion;
	private $usuario_actualizacion;
	private $conexion;
	private $seguridad;
	public  $error;
	
	#######################################  Operaciones  #######################################
	
	function __construct($conexion) {
		$this->error = NULL;
		$this->conexion = $conexion;
		$this->seguridad = new Seguridad();
	}
	
	// Insertar un Usuario a la Base de Datos
	public function insertar($usuario, $contrasena, $nombre, $apellido, $email, $foto, $sexo, $tipo) {
		if(!$usuario = $this->seguridad->texto_seguro($this->conexion, $usuario)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		if(!$contrasena = $this->seguridad->texto_seguro($this->conexion, $contrasena)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		if(!$nombre = $this->seguridad->texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		if(!$apellido = $this->seguridad->texto_seguro($this->conexion, $apellido)) {
			$this->error = "Apellido no es Seguro";
			return false;
		}
		
		if(!$email = $this->seguridad->texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!is_string($foto = $this->seguridad->texto_seguro($this->conexion, $foto))) {
			$this->error = "Foto no es Seguro";
			return false;
		}
		
		if(!$sexo = $this->seguridad->entero_seguro($sexo)) {
			$this->error = "Sexo no es Seguro";
			return false;
		}
		
		if(!$tipo = $this->seguridad->entero_seguro($tipo)) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		$sql = sprintf("INSERT INTO usuarios(usuario, contrasena, nombre, apellido, email, foto, sexo, tipo, estado, fecha_registro) VALUES('%s', SHA1('%s'), '%s', '%s', '%s', '%s', '%d', '%d', 1, CURDATE())", $usuario, $contrasena, $nombre, $apellido, $email, $foto, $sexo, $tipo);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Insertar";
			return false;
		}
	}
	
	// Actualizar un Usuario a la Base de Datos identificado por su id
	public function actualizar($id, $nombre, $apellido, $email, $foto, $sexo, $tipo) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		if(!$nombre = $this->seguridad->texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		if(!$apellido = $this->seguridad->texto_seguro($this->conexion, $apellido)) {
			$this->error = "Apellido no es Seguro";
			return false;
		}
		
		if(!$email = $this->seguridad->texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(($foto != "") && (!$foto = $this->seguridad->texto_seguro($this->conexion, $foto))) {
			$this->error = "Foto no es Seguro";
			return false;
		}
		
		if(!$sexo = $this->seguridad->entero_seguro($sexo)) {
			$this->error = "Sexo no es Seguro";
			return false;
		}
		
		if(!$tipo = $this->seguridad->entero_seguro($tipo)) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE usuarios SET nombre='%s', apellido='%s', email='%s', foto='%s', sexo='%d', tipo='%d' WHERE id='%d'", $nombre, $apellido, $email, $foto, $sexo, $tipo, $id);
		
		if($actualizo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Modificar";
			return false;
		}
	}
	
	// Eliminar un Usuario de la Base de Datos identificado por su id
	private function eliminar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM usuarios WHERE id='%d'",$id);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Desactivar un Usuario de la Base de Datos identificado por su id
	public function desactivar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE usuarios SET estado=0 WHERE id='%d'", $id);
		
		if($desactivo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar (D)";
			return false;
		}
	}
	
	// Autenticar Usuario
	public function autenticar($usuario, $contrasena) {
		if(!$usuario = $this->seguridad->texto_seguro($this->conexion, $usuario)) {
			$this->error = "Usuario no es Seguro";
			return false;
		}
		
		if(!$contrasena = $this->seguridad->texto_seguro($this->conexion, $contrasena)) {
			$this->error = "Contrasena no es Seguro";
			return false;
		}
		
		if(($usuario != "") && ($contrasena != "")) {
			$sql = sprintf("SELECT * FROM usuarios WHERE usuario='%s' AND contrasena=SHA1('%s') AND estado!=0", $usuario, $contrasena);
			if($query = mysqli_query($this->conexion, $sql)) {
				if($rusuario = mysqli_fetch_assoc($query)) {
					$_SESSION['autorizado'] = true;
					$_SESSION['usuario_id'] = $rusuario['id'];
					$_SESSION['usuario_usuario'] = $rusuario['usuario'];
					$_SESSION['usuario_nombre'] = $rusuario['nombre'];
					$_SESSION['usuario_apellido'] = $rusuario['apellido'];
					$_SESSION['usuario_email'] = $rusuario['email'];

					$_SESSION['usuario_sexo'] = $rusuario['sexo'];
					switch($rusuario['sexo']) {
						case 1: $_SESSION['usuario_csexo'] = "Femenino"; break;
						case 2: $_SESSION['usuario_csexo'] = "Masculino"; break;
						case 3: $_SESSION['usuario_csexo'] = "Otro"; break;
						default: $_SESSION['usuario_csexo'] = "---"; break;
					}

					$_SESSION['usuario_foto'] = $rusuario['foto'];
					if($rusuario['foto'] == '') {
						if($rusuario['sexo'] == 1) {
							$_SESSION['usuario_rutafoto'] = $GLOBALS['domain_root']."/img/usuario_mujer.jpg";
						} else {
							$_SESSION['usuario_rutafoto'] = $GLOBALS['domain_root']."/img/usuario_hombre.jpg";
						}
						
					} else {
						$_SESSION['usuario_rutafoto'] = $GLOBALS['domain_root']."/archivos_usuarios/".$rusuario['foto'];
					}
					
					$_SESSION['usuario_tipo'] = $rusuario['tipo'];
					switch($rusuario['tipo']) {
						case 1: $_SESSION['usuario_ctipo'] = "Webmaster";
										$_SESSION['usuario_pi'] = true;  // Permiso para Insertar
										$_SESSION['usuario_pm'] = true;  // Permiso para Modificar
										$_SESSION['usuario_pe'] = true;  // Permiso para Eliminar
										$_SESSION['usuario_psu'] = true;  // Permiso para la Seccion Usuarios
										break;
						case 2: $_SESSION['usuario_ctipo'] = "Administrador";
										$_SESSION['usuario_pi'] = true;  // Permiso para Insertar
										$_SESSION['usuario_pm'] = true;  // Permiso para Modificar
										$_SESSION['usuario_pe'] = true;  // Permiso para Eliminar
										$_SESSION['usuario_psu'] = false;  // Permiso para la Seccion Usuarios
										break;
						case 3: $_SESSION['usuario_ctipo'] = "Editor";
										$_SESSION['usuario_pi'] = false;  // Permiso para Insertar
										$_SESSION['usuario_pm'] = true;  // Permiso para Modificar
										$_SESSION['usuario_pe'] = false;  // Permiso para Eliminar
										$_SESSION['usuario_psu'] = false;  // Permiso para la Seccion Usuarios
										break;
						case 4: $_SESSION['usuario_ctipo'] = "Consultor";
										$_SESSION['usuario_pi'] = false;  // Permiso para Insertar
										$_SESSION['usuario_pm'] = false;  // Permiso para Modificar
										$_SESSION['usuario_pe'] = false;  // Permiso para Eliminar
										$_SESSION['usuario_psu'] = false;  // Permiso para la Seccion Usuarios
										break;
						default: $_SESSION['usuario_ctipo'] = "Consultor";
										$_SESSION['usuario_pi'] = false;  // Permiso para Insertar
										$_SESSION['usuario_pm'] = false;  // Permiso para Modificar
										$_SESSION['usuario_pe'] = false;  // Permiso para Eliminar
										$_SESSION['usuario_psu'] = false;  // Permiso para la Seccion Usuarios
										break;
					}
					
					$_SESSION['usuario_estado'] = $rusuario['estado'];
					$_SESSION['usuario_tiempo'] = time();
					$_SESSION['error'] = 0;
					return true;
				} else {
					$this->error = 'Usuario o Contrase&ntilde;a inv&aacute;lidos';
					return false;
				}
			} else {
				$this->error = 'No se puede consultar Usuario';
				return false;
			}
		} else {
			$this->error = 'Usuario o Contrase&ntilde;a vac&iacute;os';
			return false;
		}
	}
	
	// Obtener datos de un Usuario identifiado por su id
	public function datos($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM usuarios WHERE id='%d'", $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rusuario = mysqli_fetch_assoc($query)) {
				$this->id = $rusuario['id'];
				$this->usuario = $rusuario['usuario'];
				$this->contrasena = $rusuario['contrasena'];
				$this->nombre = $rusuario['nombre'];
				$this->apellido = $rusuario['apellido'];
				$this->email = $rusuario['email'];
				$this->foto = $rusuario['foto'];
				$this->sexo = $rusuario['sexo'];
				$this->tipo = $rusuario['tipo'];
				$this->estado = $rusuario['estado'];
				$this->fecha_registro = $rusuario['fecha_registro'];
				return true;
			} else {
				$this->error = "ID no aroja resultados";
				return false;
			}
		} else {
			$this->error = "No se puede consultar ID";
			return false;
		}
	}
	
	public function obtener_id() {
		return $this->id;
	}
	
	public function obtener_usuario() {
		return $this->usuario;
	}
	
	public function obtener_codSexo() {
		return $this->sexo;
	}
	
	public function obtener_sexo() {
		switch($this->sexo) {
			case 1: $sexo = "Femenino"; break;
			case 2: $sexo = "Masculino"; break;
			case 3: $sexo = "Otro"; break;
			default: $sexo = "---"; break;
		}
		
		return $sexo;
	}
	
	public function obtener_codTipo() {
		return $this->tipo;
	}
	
	public function obtener_tipo() {
		switch($this->tipo) {
			case 1: $tipo = "Webmaster"; break;
			case 2: $tipo = "Administrador"; break;
			case 3: $tipo = "Editor"; break;
			case 4: $tipo = "Consultor"; break;
			default: $tipo = "---"; break;
		}
		
		return $tipo;
	}
	
	public function obtener_codEstado() {
		return $this->estado;
	}
	
	public function obtener_estado() {
		switch($this->estado) {
			case 0: $estado = "Eliminado"; break;
			case 1: $estado = "Activo"; break;
			case 2: $estado = "Protegido"; break;
			default: $estado = "---"; break;
		}
		
		return $estado;
	}
	
	// Obtener listado de todos los Usuarios
	public function listado($sexo=0, $tipo=0, $estado=-1) {
		if(!is_int($sexo = $this->seguridad->entero_seguro($sexo))) {
			$this->error = "Sexo no es Seguro";
			return false;
		}
		
		if(!is_int($tipo = $this->seguridad->entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM usuarios WHERE 1=1 ";
		$argumentos = array();
		
		if($sexo > 0) {
			$formato .= "AND sexo='%d' ";
			$argumentos[] = $sexo;
		}
		
		if($tipo > 0) {
			$formato .= "AND tipo='%d' ";
			$argumentos[] = $tipo;
		}
		
		if($estado == -1) {
			$formato .= "AND estado!=0 ";
		} else {
			$formato .= "AND estado='%d' ";
			$argumentos[] = $estado;
		}
		
		$formato .= "ORDER BY id DESC";
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_usuario = new Usuario($this->conexion);
				$objeto_usuario->datos($lista['id']);
				$arreglo[] = $objeto_usuario;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de todos los Usuarios paginados
	public function listado_paginado($sexo=0, $tipo=0, $estado=-1, $inicio, $fin) {
		if(!is_int($sexo = $this->seguridad->entero_seguro($sexo))) {
			$this->error = "Sexo no es Seguro";
			return false;
		}
		
		if(!is_int($tipo = $this->seguridad->entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		if(!is_int($inicio = $this->seguridad->entero_seguro($inicio))) {
			$this->error = "N&uacute;mero de Inicio no es Seguro";
			return false;
		}
		
		if(!is_int($fin = $this->seguridad->entero_seguro($fin))) {
			$this->error = "N&uacute;mero de Fin no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM usuarios WHERE 1=1 ";
		$argumentos = array();
		
		if($sexo > 0) {
			$formato .= "AND sexo='%d' ";
			$argumentos[] = $sexo;
		}
		
		if($tipo > 0) {
			$formato .= "AND tipo='%d' ";
			$argumentos[] = $tipo;
		}
		
		if($estado == -1) {
			$formato .= "AND estado!=0 ";
		} else {
			$formato .= "AND estado='%d' ";
			$argumentos[] = $estado;
		}
		
		$formato .= "ORDER BY id DESC LIMIT %d, %d";
		$argumentos[] = $inicio;
		$argumentos[] = $fin;
		
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_usuario = new Usuario($this->conexion);
				$objeto_usuario->datos($lista['id']);
				$arreglo[] = $objeto_usuario;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de Usuarios
	public function total_listado($sexo=0, $tipo=0, $estado=-1) {
		if(!is_int($sexo = $this->seguridad->entero_seguro($sexo))) {
			$this->error = "Sexo no es Seguro";
			return false;
		}
		
		if(!is_int($tipo = $this->seguridad->entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM usuarios WHERE 1=1 ";
		$argumentos = array();
		
		if($sexo > 0) {
			$formato .= "AND sexo='%d' ";
			$argumentos[] = $sexo;
		}
		
		if($tipo > 0) {
			$formato .= "AND tipo='%d' ";
			$argumentos[] = $tipo;
		}
		
		if($estado == -1) {
			$formato .= "AND estado!=0 ";
		} else {
			$formato .= "AND estado='%d' ";
			$argumentos[] = $estado;
		}
		
		$sql = vsprintf($formato, $argumentos);
		if($query = mysqli_query($this->conexion, $sql)) {
			return mysqli_num_rows($query);
		} else {
			return 0;
		}
	}
	
	// Verificar si e-mail ya existe
	public function email_existe($email, $id) {
		if(!$email = $this->seguridad->texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!is_int($id = $this->seguridad->entero_seguro($id))) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM usuarios WHERE email='%s' AND id!='%d' AND estado!=0", $email, $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rusuario = mysqli_fetch_assoc($query)) { return true; }
			else { return false; }
		} else {
			$this->error = "No se puede consultar Email";
			return false;
		}
	}
	
	// Verificar si foto ya existe
	public function foto_existe($foto, $id) {
		if(!$foto = $this->seguridad->texto_seguro($this->conexion, $foto)) {
			$this->error = "Foto no es Seguro";
			return false;
		}
		
		if(!is_int($id = $this->seguridad->entero_seguro($id))) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM usuarios WHERE foto='%s' AND id!='%d' AND estado!=0", $foto, $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rusuario = mysqli_fetch_assoc($query)) { return true; }
			else { return false; }
		} else {
			$this->error = "No se puede consultar Foto";
			return false;
		}
	}
	
	// Cargar archivo de la imagen
	public function cargar_archivo($nombre_archivo, $temporal) {
		if($nombre_archivo != "") {
			$ruta = $GLOBALS['app_root']."/archivos_usuarios/".$nombre_archivo;
			
			if(is_uploaded_file($temporal)) {
				move_uploaded_file($temporal, $ruta);
				chmod("$ruta", 0777);
				return true;
			} else {
				$this->error = 'No se pudo cargar el archivo';
				return false;
			}
		} else {
			$this->error = 'No hay archivo';
			return false;
		}
	}
	
	// Recuperar Contraseña de un Usuario
	public function recuperar_contrasena($email, $contrasena) {
		if(!$email = $this->seguridad->texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!$contrasena = $this->seguridad->texto_seguro($this->conexion, $contrasena)) {
			$this->error = "Contraseña no es Segura";
			return false;
		}
		
		$sql = sprintf("SELECT id, nombre, apellido FROM usuarios WHERE email='%s' AND estado!=0", $email);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rusuario = mysqli_fetch_assoc($query)) {
				$this->nombre = $rusuario['nombre'];
				$this->apellido = $rusuario['apellido'];
				
				$sql2 = sprintf("UPDATE usuarios SET contrasena=SHA1('%s') WHERE id='%d'", $contrasena, $rusuario['id']);
				
				if($actualizo = mysqli_query($this->conexion, $sql2)) {
					return true;
				} else {
					$this->error = "No se puede actualizar la Contraseña";
					return false;
				}
			} else {
				$this->error = "Email no arroja resultados";
				return false;
			}
		} else {
			$this->error = "No se puede consultar Email";
			return false;
		}
	}
}
?>