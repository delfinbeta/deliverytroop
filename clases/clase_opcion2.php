<?php
class Opcion2 {
	########################################  Atributos  ########################################
	
	private $id;
	public  $nombre;
	private $estado;
	private $fecha_registro;
	private $usuario_registro;
	private $fecha_actualizacion;
	private $usuario_actualizacion;
	private $conexion;
	private $seguridad;
	public  $error = NULL;
	
	#######################################  Operaciones  #######################################
	
	function __construct($conexion) {
		$this->error = NULL;
		$this->conexion = $conexion;
		$this->seguridad = new Seguridad($conexion);
	}
	
	// Insertar un Opcion2 a la Base de Datos
	public function insertar($nombre) {
		if(!$nombre = $this->seguridad->texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		$sql = sprintf("INSERT INTO opciones2(nombre, estado, fecha_registro, usuario_registro, fecha_actualizacion, usuario_actualizacion) VALUES('%s', 1, CURDATE(), '%d', CURDATE(), '%d')", $nombre, $_SESSION['usuario_id'], $_SESSION['usuario_id']);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Insertar";
			return false;
		}
	}
	
	// Actualizar un Opcion2 a la Base de Datos identificado por su id
	public function actualizar($id, $nombre) {
		if(!$nombre = $this->seguridad->texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE opciones2 SET nombre='%s', fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='%d'", $nombre, $_SESSION['usuario_id'], $id);
		
		if($actualizo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Modificar";
			return false;
		}
	}
	
	// Eliminar un Opcion2 de la Base de Datos identificado por su id
	private function eliminar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM opciones2 WHERE id='%d'", $id);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Desactivar un Opcion2 de la Base de Datos identificado por su id
	public function desactivar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE opciones2 SET estado=0, fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='%d'", $_SESSION['usuario_id'], $id);
		
		if($desactivo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar (D)";
			return false;
		}
	}
	
	// Obtener datos de un Opcion2 identifiado por su id
	public function datos($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM opciones2 WHERE id='%d'", $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($ropcion2 = mysqli_fetch_assoc($query)) {
				$this->id = $ropcion2['id'];
				$this->nombre = $ropcion2['nombre'];
				$this->estado = $ropcion2['estado'];
				$this->fecha_registro = $ropcion2['fecha_registro'];
				$this->usuario_registro = $ropcion2['usuario_registro'];
				$this->fecha_actualizacion = $ropcion2['fecha_actualizacion'];
				$this->usuario_actualizacion = $ropcion2['usuario_actualizacion'];
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
	
	// Obtener listado de todos los Opcion2s
	public function listado($estado=-1) {
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM opciones2 WHERE 1=1 ";
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
				$objeto_opcion2 = new Opcion2($this->conexion);
				$objeto_opcion2->datos($lista['id']);
				$arreglo[] = $objeto_opcion2;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de todos los Opcion2s paginados
	public function listado_paginado($estado=-1, $inicio, $fin) {
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
		
		$formato = "SELECT id FROM opciones2 WHERE 1=1 ";
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
				$objeto_opcion2 = new Opcion2($this->conexion);
				$objeto_opcion2->datos($lista['id']);
				$arreglo[] = $objeto_opcion2;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de Opcion2s
	public function total_listado($estado=-1) {
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM opciones2 WHERE 1=1 ";
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
