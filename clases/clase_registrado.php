<?php
class Registrado extends Seguridad {
	########################################  Atributos  ########################################
	
	private $id;
	private $id_padre;
	public  $nombre;
	public  $apellido;
	public  $email;
	private $contrasena;
	private $identificacion_tipo;
	private $identificacion_documento;
	private $sexo;
	public  $foto;
	public  $telefono;
	public  $movil;
	public  $twitter;
	public  $empresa;
	public  $numero_fiscal;
	public  $cargo;
	public  $escarapela;
	private $tipo;
	public  $direccion;
	public  $ciudad;
	public  $estado2;
	public  $codigo_postal;
	private $pais;
	public  $telefono_empresa;
	public  $fax_empresa;
	public  $email_empresa;
	private $estado;
	private $fecha_registro;
	private $usuario_registro;
	private $fecha_actualizacion;
	private $usuario_actualizacion;
	private $conexion;
	public  $error;
	
	#######################################  Operaciones  #######################################
	
	function __construct($conexion) {
		$this->error = NULL;
		$this->conexion = $conexion;
	}
	
	// Insertar un Registrado a la Base de Datos
	public function insertar($id_padre, $nombre, $apellido, $email, $contrasena, $identificacion_tipo, $identificacion_documento, $sexo, $foto, $telefono, $movil, $twitter, $empresa, $numero_fiscal, $cargo, $escarapela, $tipo, $direccion, $ciudad, $estado2, $codigo_postal, $pais, $telefono_empresa, $fax_empresa, $email_empresa) {
		if(!is_int($id_padre = parent::entero_seguro($id_padre))) {
			$this->error = "ID Padre no es Seguro";
			return false;
		}
		
		if(!$nombre = parent::texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		if(!$apellido = parent::texto_seguro($this->conexion, $apellido)) {
			$this->error = "Apellido no es Seguro";
			return false;
		}

		if(!$email = parent::texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!$contrasena = parent::texto_seguro($this->conexion, $contrasena)) {
			$this->error = "Contraseña no es Seguro";
			return false;
		}
		
		if(!$identificacion_tipo = parent::entero_seguro($identificacion_tipo)) {
			$this->error = "Identificacion Tipo no es Seguro";
			return false;
		}
		
		if(!$identificacion_documento = parent::texto_seguro($this->conexion, $identificacion_documento)) {
			$this->error = "Identificacion Documento no es Seguro";
			return false;
		}
		
		if(!$sexo = parent::entero_seguro($sexo)) {
			$this->error = "Sexo no es Seguro";
			return false;
		}
		
		if(!is_string($foto = parent::texto_seguro($this->conexion, $foto))) {
			$this->error = "Foto no es Seguro";
			return false;
		}
		
		if(!is_string($telefono = parent::texto_seguro($this->conexion, $telefono))) {
			$this->error = "Telefono no es Seguro";
			return false;
		}
		
		if(!is_string($movil = parent::texto_seguro($this->conexion, $movil))) {
			$this->error = "Telefono Móvil no es Seguro";
			return false;
		}
		
		if(!is_string($twitter = parent::texto_seguro($this->conexion, $twitter))) {
			$this->error = "Twitter no es Seguro";
			return false;
		}
		
		if(!is_string($empresa = parent::texto_seguro($this->conexion, $empresa))) {
			$this->error = "Empresa no es Seguro";
			return false;
		}
		
		if(!is_string($numero_fiscal = parent::texto_seguro($this->conexion, $numero_fiscal))) {
			$this->error = "Número Fiscal no es Seguro";
			return false;
		}
		
		if(!is_string($cargo = parent::texto_seguro($this->conexion, $cargo))) {
			$this->error = "Cargo no es Seguro";
			return false;
		}
		
		if(!is_string($escarapela = parent::texto_seguro($this->conexion, $escarapela))) {
			$this->error = "Escarapela no es Seguro";
			return false;
		}
		
		if(!is_int($tipo = parent::entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!is_string($direccion = parent::texto_seguro($this->conexion, $direccion))) {
			$this->error = "Dirección no es Seguro";
			return false;
		}
		
		if(!is_string($ciudad = parent::texto_seguro($this->conexion, $ciudad))) {
			$this->error = "Ciudad no es Seguro";
			return false;
		}
		
		if(!is_string($estado2 = parent::texto_seguro($this->conexion, $estado2))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		if(!is_string($codigo_postal = parent::texto_seguro($this->conexion, $codigo_postal))) {
			$this->error = "Código Postal no es Seguro";
			return false;
		}
		
		if(!is_int($pais = parent::entero_seguro($pais))) {
			$this->error = "País no es Seguro";
			return false;
		}
		
		if(!is_string($telefono_empresa = parent::texto_seguro($this->conexion, $telefono_empresa))) {
			$this->error = "Telefono Empresa no es Seguro";
			return false;
		}
		
		if(!is_string($fax_empresa = parent::texto_seguro($this->conexion, $fax_empresa))) {
			$this->error = "Fax Empresa no es Seguro";
			return false;
		}
		
		if(!is_string($email_empresa = parent::texto_seguro($this->conexion, $email_empresa))) {
			$this->error = "Email Empresa no es Seguro";
			return false;
		}

		$usuario_id = 0;
		if(isset($_SESSION['usuario_id'])) { $usuario_id = $_SESSION['usuario_id']; }
		if(isset($_SESSION['registrado_id'])) { $usuario_id = $_SESSION['registrado_id']; }
		
		$sql = sprintf("INSERT INTO registrados(id_padre, nombre, apellido, email, contrasena, identificacion_tipo, identificacion_documento, sexo, foto, telefono, movil, twitter, empresa, numero_fiscal, cargo, escarapela, tipo, direccion, ciudad, estado2, codigo_postal, pais, telefono_empresa, fax_empresa, email_empresa, estado, fecha_registro, usuario_registro, fecha_actualizacion, usuario_actualizacion) VALUES('%d', '%s', '%s', '%s', SHA1('%s'), '%d', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', 1, CURDATE(), '%d', CURDATE(), '%d')", $id_padre, $nombre, $apellido, $email, $contrasena, $identificacion_tipo, $identificacion_documento, $sexo, $foto, $telefono, $movil, $twitter, $empresa, $numero_fiscal, $cargo, $escarapela, $tipo, $direccion, $ciudad, $estado2, $codigo_postal, $pais, $telefono_empresa, $fax_empresa, $email_empresa, $usuario_id, $usuario_id);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Insertar";
			return false;
		}
	}
	
	// Actualizar un Registrado a la Base de Datos identificado por su id
	public function actualizar($id, $nombre, $apellido, $email, $identificacion_tipo, $identificacion_documento, $sexo, $foto, $telefono, $movil, $twitter, $empresa, $numero_fiscal, $cargo, $escarapela, $tipo, $direccion, $ciudad, $estado2, $codigo_postal, $pais, $telefono_empresa, $fax_empresa, $email_empresa) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		if(!$nombre = parent::texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		if(!$apellido = parent::texto_seguro($this->conexion, $apellido)) {
			$this->error = "Apellido no es Seguro";
			return false;
		}

		if(!$email = parent::texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!$identificacion_tipo = parent::entero_seguro($identificacion_tipo)) {
			$this->error = "Identificacion Tipo no es Seguro";
			return false;
		}
		
		if(!$identificacion_documento = parent::texto_seguro($this->conexion, $identificacion_documento)) {
			$this->error = "Identificacion Documento no es Seguro";
			return false;
		}
		
		if(!$sexo = parent::entero_seguro($sexo)) {
			$this->error = "Sexo no es Seguro";
			return false;
		}
		
		if(!is_string($foto = parent::texto_seguro($this->conexion, $foto))) {
			$this->error = "Foto no es Seguro";
			return false;
		}
		
		if(!is_string($telefono = parent::texto_seguro($this->conexion, $telefono))) {
			$this->error = "Telefono no es Seguro";
			return false;
		}
		
		if(!$movil = parent::texto_seguro($this->conexion, $movil)) {
			$this->error = "Telefono Móvil no es Seguro";
			return false;
		}
		
		if(!is_string($twitter = parent::texto_seguro($this->conexion, $twitter))) {
			$this->error = "Twitter no es Seguro";
			return false;
		}
		
		if(!is_string($empresa = parent::texto_seguro($this->conexion, $empresa))) {
			$this->error = "Empresa no es Seguro";
			return false;
		}
		
		if(!is_string($numero_fiscal = parent::texto_seguro($this->conexion, $numero_fiscal))) {
			$this->error = "Número Fiscal no es Seguro";
			return false;
		}
		
		if(!is_string($cargo = parent::texto_seguro($this->conexion, $cargo))) {
			$this->error = "Cargo no es Seguro";
			return false;
		}
		
		if(!is_string($escarapela = parent::texto_seguro($this->conexion, $escarapela))) {
			$this->error = "Escarapela no es Seguro";
			return false;
		}
		
		if(!is_int($tipo = parent::entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!is_string($direccion = parent::texto_seguro($this->conexion, $direccion))) {
			$this->error = "Dirección no es Seguro";
			return false;
		}
		
		if(!is_string($ciudad = parent::texto_seguro($this->conexion, $ciudad))) {
			$this->error = "Ciudad no es Seguro";
			return false;
		}
		
		if(!is_string($estado2 = parent::texto_seguro($this->conexion, $estado2))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		if(!is_string($codigo_postal = parent::texto_seguro($this->conexion, $codigo_postal))) {
			$this->error = "Código Postal no es Seguro";
			return false;
		}
		
		if(!is_int($pais = parent::entero_seguro($pais))) {
			$this->error = "País no es Seguro";
			return false;
		}
		
		if(!is_string($telefono_empresa = parent::texto_seguro($this->conexion, $telefono_empresa))) {
			$this->error = "Telefono Empresa no es Seguro";
			return false;
		}
		
		if(!is_string($fax_empresa = parent::texto_seguro($this->conexion, $fax_empresa))) {
			$this->error = "Fax Empresa no es Seguro";
			return false;
		}
		
		if(!is_string($email_empresa = parent::texto_seguro($this->conexion, $email_empresa))) {
			$this->error = "Email Empresa no es Seguro";
			return false;
		}

		$usuario_id = 0;
		if(isset($_SESSION['usuario_id'])) { $usuario_id = $_SESSION['usuario_id']; }
		if(isset($_SESSION['registrado_id'])) { $usuario_id = $_SESSION['registrado_id']; }
		
		$sql = sprintf("UPDATE registrados SET nombre='%s', apellido='%s', email='%s', identificacion_tipo='%d', identificacion_documento='%s', sexo='%d', foto='%s', telefono='%s', movil='%s', twitter='%s', empresa='%s', numero_fiscal='%s', cargo='%s', escarapela='%s', tipo='%d', direccion='%s', ciudad='%s', estado2='%s', codigo_postal='%s', pais='%d', telefono_empresa='%s', fax_empresa='%s', email_empresa='%s', fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='%d'", $nombre, $apellido, $email, $identificacion_tipo, $identificacion_documento, $sexo, $foto, $telefono, $movil, $twitter, $empresa, $numero_fiscal, $cargo, $escarapela, $tipo, $direccion, $ciudad, $estado2, $codigo_postal, $pais, $telefono_empresa, $fax_empresa, $email_empresa, $usuario_id, $id);
		
		if($actualizo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Modificar";
			return false;
		}
	}
	
	// Eliminar un Registrado de la Base de Datos identificado por su id
	private function eliminar($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM registrados WHERE id='%d'",$id);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Desactivar un Registrado de la Base de Datos identificado por su id
	public function desactivar($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}

		$usuario_id = 0;
		if(isset($_SESSION['usuario_id'])) { $usuario_id = $_SESSION['usuario_id']; }
		if(isset($_SESSION['registrado_id'])) { $usuario_id = $_SESSION['registrado_id']; }
		
		$sql = sprintf("UPDATE registrados SET estado=0, fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='%d'", $usuario_id, $id);
		
		if($desactivo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar (D)";
			return false;
		}
	}
	
	// Autenticar Registrado
	public function autenticar($email, $contrasena) {
		if(!$email = parent::texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!$contrasena = parent::texto_seguro($this->conexion, $contrasena)) {
			$this->error = "Contrase&ntilde;a no es Seguro";
			return false;
		}
		
		if(($email != "") && ($contrasena != "")) {
			$sql = sprintf("SELECT * FROM registrados WHERE email='%s' AND contrasena=SHA1('%s') AND estado!=0", $email, $contrasena);
			if($query = mysqli_query($this->conexion, $sql)) {
				if($rregistrado = mysqli_fetch_assoc($query)) {
					$_SESSION['registrado_id'] = $rregistrado['id'];
					$_SESSION['registrado_id_padre'] = $rregistrado['id_padre'];
					$_SESSION['registrado_nombre'] = $rregistrado['nombre'];
					$_SESSION['registrado_apellido'] = $rregistrado['apellido'];
					$_SESSION['registrado_email'] = $rregistrado['email'];
					$_SESSION['registrado_identificacion_tipo'] = $rregistrado['identificacion_tipo'];
					$_SESSION['registrado_identificacion_documento'] = $rregistrado['identificacion_documento'];
					$_SESSION['registrado_sexo'] = $rregistrado['sexo'];
					$_SESSION['registrado_foto'] = $rregistrado['foto'];
					$_SESSION['registrado_telefono'] = $rregistrado['telefono'];
					$_SESSION['registrado_movil'] = $rregistrado['movil'];
					$_SESSION['registrado_twitter'] = $rregistrado['twitter'];
					$_SESSION['registrado_empresa'] = $rregistrado['empresa'];
					$_SESSION['registrado_numero_fiscal'] = $rregistrado['numero_fiscal'];
					$_SESSION['registrado_cargo'] = $rregistrado['cargo'];
					$_SESSION['registrado_escarapela'] = $rregistrado['escarapela'];
					$_SESSION['registrado_tipo'] = $rregistrado['tipo'];
					$_SESSION['registrado_direccion'] = $rregistrado['direccion'];
					$_SESSION['registrado_ciudad'] = $rregistrado['ciudad'];
					$_SESSION['registrado_estado2'] = $rregistrado['estado2'];
					$_SESSION['registrado_codigo_postal'] = $rregistrado['codigo_postal'];
					$_SESSION['registrado_pais'] = $rregistrado['pais'];
					$_SESSION['registrado_telefono_empresa'] = $rregistrado['telefono_empresa'];
					$_SESSION['registrado_fax_empresa'] = $rregistrado['fax_empresa'];
					$_SESSION['registrado_email_empresa'] = $rregistrado['email_empresa'];
					$_SESSION['registrado_estado'] = $rregistrado['estado'];
					$_SESSION['registrado_tiempo'] = time();
					$_SESSION['registrado_error'] = 0;
					return true;
				} else {
					$this->error = 'Email o Contrase&ntilde;a invalidos';
					return false;
				}
			} else {
				$this->error = 'No se puede consultar Registrado';
				return false;
			}
		} else {
			$this->error = 'Email o Contrase&ntilde;a vacios';
			return false;
		}
	}
	
	// Obtener datos de un Registrado identifiado por su id
	public function datos($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM registrados WHERE id='%d'", $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rregistrado = mysqli_fetch_assoc($query)) {
				$this->id = $rregistrado['id'];
				$this->id_padre = $rregistrado['id_padre'];
				$this->nombre = $rregistrado['nombre'];
				$this->apellido = $rregistrado['apellido'];
				$this->email = $rregistrado['email'];
				$this->identificacion_tipo = $rregistrado['identificacion_tipo'];
				$this->identificacion_documento = $rregistrado['identificacion_documento'];
				$this->sexo = $rregistrado['sexo'];
				$this->foto = $rregistrado['foto'];
				$this->telefono = $rregistrado['telefono'];
				$this->movil = $rregistrado['movil'];
				$this->twitter = $rregistrado['twitter'];
				$this->empresa = $rregistrado['empresa'];
				$this->numero_fiscal = $rregistrado['numero_fiscal'];
				$this->cargo = $rregistrado['cargo'];
				$this->escarapela = $rregistrado['escarapela'];
				$this->tipo = $rregistrado['tipo'];
				$this->direccion = $rregistrado['direccion'];
				$this->ciudad = $rregistrado['ciudad'];
				$this->estado2 = $rregistrado['estado2'];
				$this->codigo_postal = $rregistrado['codigo_postal'];
				$this->pais = $rregistrado['pais'];
				$this->telefono_empresa = $rregistrado['telefono_empresa'];
				$this->fax_empresa = $rregistrado['fax_empresa'];
				$this->email_empresa = $rregistrado['email_empresa'];
				$this->estado = $rregistrado['estado'];
				$this->fecha_registro = $rregistrado['fecha_registro'];
				$this->usuario_registro = $rregistrado['usuario_registro'];
				$this->fecha_actualizacion = $rregistrado['fecha_actualizacion'];
				$this->usuario_actualizacion = $rregistrado['usuario_actualizacion'];
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
	
	// Obtener datos de un Registrado identifiado por su id
	public function datos2($email) {
		if(!$email = parent::texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM registrados WHERE email='%s'", $email);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rregistrado = mysqli_fetch_assoc($query)) {
				$this->id = $rregistrado['id'];
				$this->id_padre = $rregistrado['id_padre'];
				$this->nombre = $rregistrado['nombre'];
				$this->apellido = $rregistrado['apellido'];
				$this->email = $rregistrado['email'];
				$this->identificacion_tipo = $rregistrado['identificacion_tipo'];
				$this->identificacion_documento = $rregistrado['identificacion_documento'];
				$this->sexo = $rregistrado['sexo'];
				$this->foto = $rregistrado['foto'];
				$this->telefono = $rregistrado['telefono'];
				$this->movil = $rregistrado['movil'];
				$this->twitter = $rregistrado['twitter'];
				$this->empresa = $rregistrado['empresa'];
				$this->numero_fiscal = $rregistrado['numero_fiscal'];
				$this->cargo = $rregistrado['cargo'];
				$this->escarapela = $rregistrado['escarapela'];
				$this->tipo = $rregistrado['tipo'];
				$this->direccion = $rregistrado['direccion'];
				$this->ciudad = $rregistrado['ciudad'];
				$this->estado2 = $rregistrado['estado2'];
				$this->codigo_postal = $rregistrado['codigo_postal'];
				$this->pais = $rregistrado['pais'];
				$this->telefono_empresa = $rregistrado['telefono_empresa'];
				$this->fax_empresa = $rregistrado['fax_empresa'];
				$this->email_empresa = $rregistrado['email_empresa'];
				$this->estado = $rregistrado['estado'];
				$this->fecha_registro = $rregistrado['fecha_registro'];
				$this->usuario_registro = $rregistrado['usuario_registro'];
				$this->fecha_actualizacion = $rregistrado['fecha_actualizacion'];
				$this->usuario_actualizacion = $rregistrado['usuario_actualizacion'];
				return true;
			} else {
				$this->error = "Email no aroja resultados";
				return false;
			}
		} else {
			$this->error = "No se puede consultar Email";
			return false;
		}
	}
	
	public function obtener_id() {
		return $this->id;
	}
	
	public function obtener_id_padre() {
		return $this->id_padre;
	}
	
	public function obtener_codIdentificacion_tipo() {
		return $this->identificacion_tipo;
	}
	
	public function obtener_identificacion_tipo() {
		switch($this->identificacion_tipo) {
			case 1: $identificacion_tipo = "Cedula Ciudadania / ID Number"; break;
			case 2: $identificacion_tipo = "Pasaporte / Passport Number"; break;
			case 3: $identificacion_tipo = "Licencia de Conducir / Driver License"; break;
			default: $identificacion_tipo = "---"; break;
		}
		
		return $identificacion_tipo;
	}
	
	public function obtener_identificacion_documento() {
		return $this->identificacion_documento;
	}
	
	public function obtener_codSexo() {
		return $this->sexo;
	}
	
	public function obtener_sexo() {
		if($this->sexo == 1) { $sexo = "Femenino / Female"; }
		else { $sexo = "Masculino / Male"; }
		
		return $sexo;
	}
	
	public function obtener_codTipo() {
		return $this->tipo;
	}
	
	public function obtener_tipo() {
		if($this->tipo == 1) { $tipo = "Entidad Financiera / Financial Institution"; }
		else { $tipo = "Entidad No Financiera / Non-Financial Institution"; }
		
		return $tipo;
	}
	
	public function obtener_codPais() {
		return $this->pais;
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
	
	public function obtener_fecha_registro() {
		return $this->fecha_registro;
	}
	
	// Obtener listado de todos los Registrados
	public function listado($id_padre=0, $sexo=0, $tipo=0, $pais=0, $estado=-1, $nombre='') {
		if(!is_int($id_padre = parent::entero_seguro($id_padre))) {
			$this->error = "ID Padre no es Seguro";
			return false;
		}
		
		if(!is_int($sexo = parent::entero_seguro($sexo))) {
			$this->error = "Sexo no es Seguro";
			return false;
		}
		
		if(!is_int($tipo = parent::entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!is_int($pais = parent::entero_seguro($pais))) {
			$this->error = "Pais no es Seguro";
			return false;
		}
		
		if(!is_int($estado = parent::entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}

		if(!is_string($nombre = parent::texto_seguro($this->conexion, $nombre))) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM registrados WHERE 1=1 ";
		$argumentos = array();
		
		if($id_padre > 0) {
			$formato .= "AND id_padre='%d' ";
			$argumentos[] = $id_padre;
		}
		
		if($sexo > 0) {
			$formato .= "AND sexo='%d' ";
			$argumentos[] = $sexo;
		}
		
		if($tipo > 0) {
			$formato .= "AND tipo='%d' ";
			$argumentos[] = $tipo;
		}
		
		if($pais > 0) {
			$formato .= "AND pais='%d' ";
			$argumentos[] = $pais;
		}
		
		if($estado == -1) {
			$formato .= "AND estado!=0 ";
		} else {
			$formato .= "AND estado='%d' ";
			$argumentos[] = $estado;
		}

		if($nombre != '') {
			$palabras = explode(' ',$nombre);
			foreach($palabras as $palabra) {
				$formato .= "AND (nombre LIKE '%s' OR apellido LIKE '%s') ";
				$argumentos[] = '%'.$palabra.'%';
				$argumentos[] = '%'.$palabra.'%';
			}
		}
		
		$formato .= "ORDER BY id DESC";
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_registrado = new Registrado($this->conexion);
				$objeto_registrado->datos($lista['id']);
				$arreglo[] = $objeto_registrado;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de todos los Registrados paginados
	public function listado_paginado($id_padre=0, $sexo=0, $tipo=0, $pais=0, $estado=-1, $nombre='', $inicio, $fin) {
		if(!is_int($id_padre = parent::entero_seguro($id_padre))) {
			$this->error = "ID Padre no es Seguro";
			return false;
		}
		
		if(!is_int($sexo = parent::entero_seguro($sexo))) {
			$this->error = "Sexo no es Seguro";
			return false;
		}
		
		if(!is_int($tipo = parent::entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!is_int($pais = parent::entero_seguro($pais))) {
			$this->error = "Pais no es Seguro";
			return false;
		}
		
		if(!is_int($estado = parent::entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}

		if(!is_string($nombre = parent::texto_seguro($this->conexion, $nombre))) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		if(!is_int($inicio = parent::entero_seguro($inicio))) {
			$this->error = "N&uacute;mero de Inicio no es Seguro";
			return false;
		}
		
		if(!is_int($fin = parent::entero_seguro($fin))) {
			$this->error = "N&uacute;mero de Fin no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM registrados WHERE 1=1 ";
		$argumentos = array();
		
		if($id_padre > 0) {
			$formato .= "AND id_padre='%d' ";
			$argumentos[] = $id_padre;
		}
		
		if($sexo > 0) {
			$formato .= "AND sexo='%d' ";
			$argumentos[] = $sexo;
		}
		
		if($tipo > 0) {
			$formato .= "AND tipo='%d' ";
			$argumentos[] = $tipo;
		}
		
		if($pais > 0) {
			$formato .= "AND pais='%d' ";
			$argumentos[] = $pais;
		}
		
		if($estado == -1) {
			$formato .= "AND estado!=0 ";
		} else {
			$formato .= "AND estado='%d' ";
			$argumentos[] = $estado;
		}

		if($nombre != '') {
			$palabras = explode(' ',$nombre);
			foreach($palabras as $palabra) {
				$formato .= "AND (nombre LIKE '%s' OR apellido LIKE '%s') ";
				$argumentos[] = '%'.$palabra.'%';
				$argumentos[] = '%'.$palabra.'%';
			}
		}
		
		$formato .= "ORDER BY id DESC LIMIT %d, %d";
		$argumentos[] = $inicio;
		$argumentos[] = $fin;
		
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_registrado = new Registrado($this->conexion);
				$objeto_registrado->datos($lista['id']);
				$arreglo[] = $objeto_registrado;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de Registrados
	public function total_listado($id_padre=0, $sexo=0, $tipo=0, $pais=0, $estado=-1, $nombre='') {
		if(!is_int($id_padre = parent::entero_seguro($id_padre))) {
			$this->error = "ID Padre no es Seguro";
			return false;
		}
		
		if(!is_int($sexo = parent::entero_seguro($sexo))) {
			$this->error = "Sexo no es Seguro";
			return false;
		}
		
		if(!is_int($tipo = parent::entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!is_int($pais = parent::entero_seguro($pais))) {
			$this->error = "Pais no es Seguro";
			return false;
		}
		
		if(!is_int($estado = parent::entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}

		if(!is_string($nombre = parent::texto_seguro($this->conexion, $nombre))) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM registrados WHERE 1=1 ";
		$argumentos = array();
		
		if($id_padre > 0) {
			$formato .= "AND id_padre='%d' ";
			$argumentos[] = $id_padre;
		}
		
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

		if($nombre != '') {
			$palabras = explode(' ',$nombre);
			foreach($palabras as $palabra) {
				$formato .= "AND (nombre LIKE '%s' OR apellido LIKE '%s') ";
				$argumentos[] = '%'.$palabra.'%';
				$argumentos[] = '%'.$palabra.'%';
			}
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
		if(!$email = parent::texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!is_int($id = parent::entero_seguro($id))) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM registrados WHERE email='%s' AND id!='%d' AND estado!=0", $email, $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rregistrado = mysqli_fetch_assoc($query)) { return true; }
			else { return false; }
		} else {
			$this->error = "No se puede consultar Email";
			return false;
		}
	}
	
	// Verificar si foto ya existe
	public function foto_existe($foto, $id) {
		if(!$foto = parent::texto_seguro($this->conexion, $foto)) {
			$this->error = "Foto no es Seguro";
			return false;
		}
		
		if(!is_int($id = parent::entero_seguro($id))) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM registrados WHERE foto='%s' AND id!='%d' AND estado!=0", $foto, $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rregistrado = mysqli_fetch_assoc($query)) { return true; }
			else { return false; }
		} else {
			$this->error = "No se puede consultar Foto";
			return false;
		}
	}
	
	// Cargar archivo de la imagen
	public function cargar_archivo($nombre_archivo, $temporal) {
		if($nombre_archivo != "") {
			//$ruta = $_SERVER['DOCUMENT_ROOT']."/felaban_eventos/imagenes_registrados/".$nombre_archivo;
			$ruta = $_SERVER['DOCUMENT_ROOT']."/imagenes_registrados/".$nombre_archivo;
			
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
	
	// Recuperar Contraseña de un Registrado
	public function recuperar_contrasena($email, $contrasena) {
		if(!$email = parent::texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!$contrasena = parent::texto_seguro($this->conexion, $contrasena)) {
			$this->error = "Contrase&ntilde;a no es Segura";
			return false;
		}
		
		$sql = sprintf("SELECT id, nombre, apellido FROM registrados WHERE email='%s' AND estado!=0", $email);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rusuario = mysqli_fetch_assoc($query)) {
				$this->nombre = $rusuario['nombre'];
				$this->apellido = $rusuario['apellido'];
				
				$sql2 = sprintf("UPDATE registrados SET contrasena=SHA1('%s'), fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='%d'", $contrasena, $rusuario['id'], $rusuario['id']);
				
				if($actualizo = mysqli_query($this->conexion, $sql2)) {
					return true;
				} else {
					$this->error = "No se puede actualizar la Contrase&ntilde;a";
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

	// Cambiar Contraseña
	public function cambiar_contrasena($contrasena_actual, $contrasena_nueva) {
		if(!$contrasena_actual = parent::texto_seguro($this->conexion, $contrasena_actual)) {
			$this->error = "Contrasena Actual no es Seguro";
			return false;
		}
		
		if(!$contrasena_nueva = parent::texto_seguro($this->conexion, $contrasena_nueva)) {
			$this->error = "Contrasena Nueva no es Seguro";
			return false;
		}
		
		if(($contrasena_actual != "") && ($contrasena_nueva != "")) {
			$sql = sprintf("SELECT id FROM registrados WHERE contrasena=SHA1('%s') AND id='%d' AND estado!=0", $contrasena_actual, $_SESSION['registrado_id']);
			
			if($query = mysqli_query($this->conexion, $sql)) {
				if($rregistrado = mysqli_fetch_assoc($query)) {
					$sql = sprintf("UPDATE registrados SET contrasena=SHA1('%s'), fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='%d'", $contrasena_nueva, $_SESSION['registrado_id'], $_SESSION['registrado_id']);
					
					if($actualizo = mysqli_query($this->conexion, $sql)) {
						return true;
					} else {
						$this->error = 'No se puede Actualizar Contrase&ntilde;a';
						return false;
					}
				} else {
					$this->error = 'Contrase&ntilde;a Actual inv&aacute;lida';
					return false;
				}
			} else {
				$this->error = 'No se puede consultar Contrase&ntilde;a';
				return false;
			}
		} else {
			$this->error = 'Contrase&ntilde;as vac&iacute;as';
			return false;
		}
	}
}
?>
