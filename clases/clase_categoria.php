<?php
class Categoria {
	########################################  Atributos  ########################################
	
	private $id;
	private $tipo;
	public  $nombre;
	private $estado;
	private $fecha_registro;
	private $conexion;
	private $seguridad;
	public  $error = NULL;
	
	#######################################  Operaciones  #######################################
	
	function __construct($conexion) {
		$this->error = NULL;
		$this->conexion = $conexion;
		$this->seguridad = new Seguridad($conexion);
	}
	
	// Insertar un Categoria a la Base de Datos
	public function insertar($tipo, $nombre) {
		if(!$tipo = $this->seguridad->entero_seguro($tipo)) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!$nombre = $this->seguridad->texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		$sql = sprintf("INSERT INTO categorias(tipo, nombre, estado, fecha_registro) VALUES('%d', '%s', 1, CURDATE())", $tipo, $nombre);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Insertar";
			return false;
		}
	}
	
	// Actualizar un Categoria a la Base de Datos identificado por su id
	public function actualizar($id, $tipo, $nombre) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		if(!$tipo = $this->seguridad->entero_seguro($tipo)) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!$nombre = $this->seguridad->texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE categorias SET tipo='%d', nombre='%s' WHERE id='%d'", $tipo, $nombre, $id);
		
		if($actualizo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Modificar";
			return false;
		}
	}
	
	// Eliminar un Categoria de la Base de Datos identificado por su id
	private function eliminar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM categorias WHERE id='%d'", $id);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Desactivar un Categoria de la Base de Datos identificado por su id
	public function desactivar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE categorias SET estado=0 WHERE id='%d'", $id);
		
		if($desactivo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar (D)";
			return false;
		}
	}
	
	// Obtener datos de un Categoria identifiado por su id
	public function datos($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM categorias WHERE id='%d'", $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rcategoria = mysqli_fetch_assoc($query)) {
				$this->id = $rcategoria['id'];
				$this->tipo = $rcategoria['tipo'];
				$this->nombre = $rcategoria['nombre'];
				$this->estado = $rcategoria['estado'];
				$this->fecha_registro = $rcategoria['fecha_registro'];
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
	
	public function obtener_codTipo() {
		return $this->tipo;
	}
	
	public function obtener_tipo() {
		switch($this->tipo) {
			case 1: $tipo = "Restaurants"; break;
			case 2: $tipo = "Drinks"; break;
			case 3: $tipo = "Others"; break;
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
	
	// Obtener listado de todos los Categorias
	public function listado($tipo=0, $estado=-1) {
		if(!is_int($tipo = $this->seguridad->entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM categorias WHERE 1=1 ";
		$argumentos = array();
		
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
		
		$formato .= "ORDER BY id";
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_categoria = new Categoria($this->conexion);
				$objeto_categoria->datos($lista['id']);
				$arreglo[] = $objeto_categoria;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de todos los Categorias paginados
	public function listado_paginado($tipo=0, $estado=-1, $inicio, $fin) {
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
		
		$formato = "SELECT id FROM categorias WHERE 1=1 ";
		$argumentos = array();
		
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
		
		$formato .= "ORDER BY id LIMIT %d, %d";
		$argumentos[] = $inicio;
		$argumentos[] = $fin;
		
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_categoria = new Categoria($this->conexion);
				$objeto_categoria->datos($lista['id']);
				$arreglo[] = $objeto_categoria;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de Categorias
	public function total_listado($tipo=0, $estado=-1) {
		if(!is_int($tipo = $this->seguridad->entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}
		
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM categorias WHERE 1=1 ";
		$argumentos = array();
		
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
}
?>
