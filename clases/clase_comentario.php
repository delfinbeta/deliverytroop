<?php
class Comentario extends Seguridad {
	########################################  Atributos  ########################################
	
	private $id;
	public  $nombre;
	public  $email;
	public  $comentario;
	public  $respondido;
	public  $respuesta;
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
	public function insertar($nombre, $email, $comentario) {
		if(!$nombre = parent::texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		if(!$email = parent::texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!$comentario = parent::texto_seguro($this->conexion, $comentario)) {
			$this->error = "Comentario no es Seguro";
			return false;
		}
		
		$usuario_id = 0;
		if(isset($_SESSION['usuario_id'])) { $usuario_id = $_SESSION['usuario_id']; }
		if(isset($_SESSION['registrado_id'])) { $usuario_id = $_SESSION['registrado_id']; }
		
		$sql = sprintf("INSERT INTO comentarios(nombre, email, comentario, respondido, respuesta, estado, fecha_registro, usuario_registro, fecha_actualizacion, usuario_actualizacion) VALUES('%s', '%s', '%s', 0, '', 1, CURDATE(), '%d', CURDATE(), '%d')", $nombre, $email, $comentario, $usuario_id, $usuario_id);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Insertar<br />".$sql;
			return false;
		}
	}
	
	// Marcar Comentario como respondido identificado por su id
	public function responder($id, $respuesta) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		if(!is_string($respuesta = parent::texto_seguro($this->conexion, $respuesta))) {
			$this->error = "Respuesta no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE comentarios SET respondido=1, respuesta='%s', fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='$id'", $respuesta, $_SESSION['usuario_id'], $id);
		
		if($actualizo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Actualizar";
			return false;
		}
	}
	
	// Eliminar un Comentario de la Base de Datos identificado por su id
	private function eliminar($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM comentarios WHERE id='%d'",$id);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Desactivar un Comentario de la Base de Datos identificado por su id
	public function desactivar($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE comentarios SET estado=0, fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='%d'", $_SESSION['usuario_id'], $id);

		if($desactivo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar (D)";
			return false;
		}
	}
	
	// Obtener datos de un Comentario identifiado por su id
	public function datos($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM comentarios WHERE id='%d'", $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($comentario = mysqli_fetch_assoc($query)) {
				$this->id = $comentario['id'];
				$this->nombre = $comentario['nombre'];
				$this->email = $comentario['email'];
				$this->comentario = $comentario['comentario'];
				$this->respondido = $comentario['respondido'];
				$this->respuesta = $comentario['respuesta'];
				$this->estado = $comentario['estado'];
				$this->fecha_registro = $comentario['fecha_registro'];
				$this->usuario_registro = $comentario['usuario_registro'];
				$this->fecha_actualizacion = $comentario['fecha_actualizacion'];
				$this->usuario_actualizacion = $comentario['usuario_actualizacion'];
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
	
	// Obtener listado de todos los Comentarios
	public function listado($estado=-1) {
		if(!is_int($estado = parent::entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM comentarios WHERE 1=1 ";
		$argumentos = array();

		if($estado == -1) {
			$formato .= "AND estado!=0 ";
		} else {
			$formato .= "AND estado='%d' ";
			$argumentos[] = $estado;
		}
		
		$formato .= "ORDER BY fechar_registro DESC, id DESC";
		$sql = vsprintf($formato, $argumentos);

		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_comentario = new Comentario($this->conexion);
				$objeto_comentario->datos($lista['id']);
				$arreglo[] = $objeto_comentario;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de todos los Contenidos paginados
	public function listado_paginado($estado=-1, $inicio, $fin) {
		if(!is_int($estado = parent::entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
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
		
		$formato = "SELECT id FROM comentarios WHERE 1=1 ";
		$argumentos = array();
		
		if($estado == -1) {
			$formato .= "AND estado!=0 ";
		} else {
			$formato .= "AND estado='%d' ";
			$argumentos[] = $estado;
		}
		
		$formato .= "ORDER BY fecha_registro DESC, id DESC LIMIT %d, %d";
		$argumentos[] = $inicio;
		$argumentos[] = $fin;
		
		$sql = vsprintf($formato, $argumentos);

		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_comentario = new Comentario($this->conexion);
				$objeto_comentario->datos($lista['id']);
				$arreglo[] = $objeto_comentario;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de Comentarios
	public function total_listado($estado=-1) {
		if(!is_int($estado = parent::entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM comentarios WHERE 1=1 ";
		$argumentos = array();
		
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
}
?>
