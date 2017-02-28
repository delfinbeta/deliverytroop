<?php
class Contenido extends Seguridad {
	########################################  Atributos  ########################################
	
	private $id;
	public  $nombre;
	public  $descripcion;
	private $estado;
	private $fecha_registro;
	private $usuario_registro;
	private $fecha_actualizacion;
	private $usuario_actualizacion;
	private $conexion;
	public  $error = NULL;
	
	#######################################  Operaciones  #######################################
	
	function __construct($conexion) {
		$this->error = NULL;
		$this->conexion = $conexion;
	}
	
	// Insertar un Contenido a la Base de Datos
	public function insertar($nombre, $descripcion) {
		if(!$nombre = parent::texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre Español no es Seguro";
			return false;
		}
		
		if(!is_string($descripcion = parent::texto_seguro($this->conexion, $descripcion))) {
			$this->error = "Descripción Español no es Seguro";
			return false;
		}
		
		$sql = sprintf("INSERT INTO contenidos(nombre, descripcion, estado, fecha_registro, usuario_registro, fecha_actualizacion, usuario_actualizacion) VALUES('%s', '%s', 1, CURDATE(), '%d', CURDATE(), '%d')", $nombre, $descripcion, $_SESSION['usuario_id'], $_SESSION['usuario_id']);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Insertar";
			return false;
		}
	}
	
	// Actualizar un Contenido a la Base de Datos identificado por su id
	public function actualizar($id, $nombre, $descripcion) {
		if(!$nombre = parent::texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre Español no es Seguro";
			return false;
		}
		
		if(!is_string($descripcion = parent::texto_seguro($this->conexion, $descripcion))) {
			$this->error = "Descripción Español no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE contenidos SET nombre='%s', descripcion='%s', fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='%d'", $nombre, $descripcion, $_SESSION['usuario_id'], $id);
		
		if($actualizo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Modificar";
			return false;
		}
	}
	
	// Eliminar un Contenido de la Base de Datos identificado por su id
	private function eliminar($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM contenidos WHERE id='%d'", $id);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Desactivar un Contenido de la Base de Datos identificado por su id
	public function desactivar($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE contenidos SET estado=0, fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='%d'", $_SESSION['usuario_id'], $id);
		
		if($desactivo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar (D)";
			return false;
		}
	}
	
	// Obtener datos de un Contenido identifiado por su id
	public function datos($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM contenidos WHERE id='%d'", $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rcontenido = mysqli_fetch_assoc($query)) {
				$this->id = $rcontenido['id'];
				$this->nombre = $rcontenido['nombre'];
				$this->descripcion = $rcontenido['descripcion'];
				$this->estado = $rcontenido['estado'];
				$this->fecha_registro = $rcontenido['fecha_registro'];
				$this->usuario_registro = $rcontenido['usuario_registro'];
				$this->fecha_actualizacion = $rcontenido['fecha_actualizacion'];
				$this->usuario_actualizacion = $rcontenido['usuario_actualizacion'];
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
	
	// Obtener listado de todos los Contenidos
	public function listado($estado=-1) {
		if(!is_int($estado = parent::entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM contenidos WHERE 1=1 ";
		$argumentos = array();
		
		if($estado == -1) {
			$formato .= "AND estado!=0 ";
		} else {
			$formato .= "AND estado='%d' ";
			$argumentos[] = $estado;
		}
		
		$formato .= "ORDER BY id";
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_contenido = new Contenido($this->conexion);
				$objeto_contenido->datos($lista['id']);
				$arreglo[] = $objeto_contenido;
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
		
		$formato = "SELECT id FROM contenidos WHERE 1=1 ";
		$argumentos = array();
		
		if($estado == -1) {
			$formato .= "AND estado!=0 ";
		} else {
			$formato .= "AND estado='%d' ";
			$argumentos[] = $estado;
		}
		
		$formato .= "ORDER BY id LIMIT %d, %d";
		$argumentos[] = $inicio;
		$argumentos[] = $fin;
		
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_contenido = new Contenido($this->conexion);
				$objeto_contenido->datos($lista['id']);
				$arreglo[] = $objeto_contenido;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de Contenidos
	public function total_listado($estado=-1) {
		if(!is_int($estado = parent::entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM contenidos WHERE 1=1 ";
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
