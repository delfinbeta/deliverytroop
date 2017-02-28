<?php
class OrdenPlato {
	########################################  Atributos  ########################################
	
	private $orden;
	private $tipo;
	private $plato;
	public  $observaciones;
	public  $cantidad;
	public  $costo;
	private $conexion;
	private $seguridad;
	public  $error = NULL;
	
	#######################################  Operaciones  #######################################
	
	function __construct($conexion) {
		$this->error = NULL;
		$this->conexion = $conexion;
		$this->seguridad = new Seguridad($conexion);
	}
	
	// Insertar un OrdenPlato a la Base de Datos
	public function insertar($orden, $tipo, $plato, $observaciones, $cantidad, $costo) {
		if(!$orden = $this->seguridad->entero_seguro($orden)) {
			$this->error = "Orden no es Seguro";
			return false;
		}

		if(!$tipo = $this->seguridad->entero_seguro($tipo)) {
			$this->error = "Tipo no es Seguro";
			return false;
		}

		if(!$plato = $this->seguridad->entero_seguro($plato)) {
			$this->error = "Plato no es Seguro";
			return false;
		}

		if(!is_string($observaciones = $this->seguridad->texto_seguro($this->conexion, $observaciones))) {
			$this->error = "Observaciones no es Seguro";
			return false;
		}

		if(!$cantidad = $this->seguridad->entero_seguro($cantidad)) {
			$this->error = "Cantidad no es Seguro";
			return false;
		}

		if(!is_float($costo = $this->seguridad->float_seguro($costo))) {
			$this->error = "Costo no es Seguro";
			return false;
		}
		
		$sql = sprintf("INSERT INTO ordenes_platos(orden, tipo, plato, observaciones, cantidad, costo) VALUES('%d', '%d', '%d', '%s', '%d', '%f')", $orden, $tipo, $plato, $observaciones, $cantidad, $costo);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Insertar";
			return false;
		}
	}
	
	// Actualizar un OrdenPlato a la Base de Datos ordenentificado por su orden
	public function actualizar($orden, $tipo, $plato, $observaciones, $cantidad, $costo) {
		if(!$orden = $this->seguridad->entero_seguro($orden)) {
			$this->error = "Orden no es Seguro";
			return false;
		}

		if(!$tipo = $this->seguridad->entero_seguro($tipo)) {
			$this->error = "Tipo no es Seguro";
			return false;
		}

		if(!$plato = $this->seguridad->entero_seguro($plato)) {
			$this->error = "Plato no es Seguro";
			return false;
		}

		if(!is_string($observaciones = $this->seguridad->texto_seguro($this->conexion, $observaciones))) {
			$this->error = "Observaciones no es Seguro";
			return false;
		}

		if(!$cantidad = $this->seguridad->entero_seguro($cantidad)) {
			$this->error = "Cantidad no es Seguro";
			return false;
		}

		if(!is_float($costo = $this->seguridad->float_seguro($costo))) {
			$this->error = "Costo no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE ordenes_platos SET observaciones='%s', cantidad='%d', costo='%f' WHERE orden='%d' AND tipo='%d' AND plato='%d'", $observaciones, $cantidad, $costo, $orden, $tipo, $plato);
		
		if($actualizo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Modificar";
			return false;
		}
	}
	
	// Eliminar un OrdenPlato de la Base de Datos ordenentificado por su orden
	public function eliminar($orden, $tipo, $plato) {
		if(!$orden = $this->seguridad->entero_seguro($orden)) {
			$this->error = "Orden no es Seguro";
			return false;
		}

		if(!$tipo = $this->seguridad->entero_seguro($tipo)) {
			$this->error = "Tipo no es Seguro";
			return false;
		}

		if(!$plato = $this->seguridad->entero_seguro($plato)) {
			$this->error = "Plato no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM ordenes_platos WHERE orden='%d' AND tipo='%d' AND plato='%d'", $orden, $tipo, $plato);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Obtener datos de un OrdenPlato ordenentifiado por su orden
	public function datos($orden, $tipo, $plato) {
		if(!$orden = $this->seguridad->entero_seguro($orden)) {
			$this->error = "Orden no es Seguro";
			return false;
		}

		if(!$tipo = $this->seguridad->entero_seguro($tipo)) {
			$this->error = "Tipo no es Seguro";
			return false;
		}

		if(!$plato = $this->seguridad->entero_seguro($plato)) {
			$this->error = "Plato no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM ordenes_platos WHERE orden='%d' AND tipo='%d' AND plato='%d'", $orden, $tipo, $plato);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rordenes_platos = mysqli_fetch_assoc($query)) {
				$this->orden = $rordenes_platos['orden'];
				$this->tipo = $rordenes_platos['tipo'];
				$this->plato = $rordenes_platos['plato'];
				$this->observaciones = $rordenes_platos['observaciones'];
				$this->cantidad = $rordenes_platos['cantidad'];
				$this->costo = $rordenes_platos['costo'];
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
	
	public function obtener_orden() {
		return $this->orden;
	}
	
	public function obtener_tipo() {  // 1=Plato - 2=Extra
		return $this->tipo;
	}
	
	public function obtener_plato() {
		return $this->plato;
	}
	
	// Obtener listado de todos los OrdenPlatos
	public function listado($orden=0, $tipo=0, $plato=0) {
		if(!is_int($orden = $this->seguridad->entero_seguro($orden))) {
			$this->error = "Orden no es Seguro";
			return false;
		}

		if(!is_int($tipo = $this->seguridad->entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}

		if(!is_int($plato = $this->seguridad->entero_seguro($plato))) {
			$this->error = "Plato no es Seguro";
			return false;
		}
		
		$formato = "SELECT * FROM ordenes_platos WHERE 1=1 ";
		$argumentos = array();

		if($orden > 0) {
			$formato .= "AND orden='%d' ";
			$argumentos[] = $orden;
		}

		if($tipo > 0) {
			$formato .= "AND tipo='%d' ";
			$argumentos[] = $tipo;
		}

		if($plato > 0) {
			$formato .= "AND plato='%d' ";
			$argumentos[] = $plato;
		}
		
		$formato .= "ORDER BY orden, plato";
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_ordenes_platos = new OrdenPlato($this->conexion);
				$objeto_ordenes_platos->datos($lista['orden'], $lista['tipo'], $lista['plato']);
				$arreglo[] = $objeto_ordenes_platos;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de todos los OrdenPlatos paginados
	public function listado_paginado($orden=0, $tipo=0, $plato=0, $inicio, $fin) {
		if(!is_int($orden = $this->seguridad->entero_seguro($orden))) {
			$this->error = "Orden no es Seguro";
			return false;
		}

		if(!is_int($tipo = $this->seguridad->entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}

		if(!is_int($plato = $this->seguridad->entero_seguro($plato))) {
			$this->error = "Plato no es Seguro";
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
		
		$formato = "SELECT * FROM ordenes_platos WHERE 1=1 ";
		$argumentos = array();

		if($orden > 0) {
			$formato .= "AND orden='%d' ";
			$argumentos[] = $orden;
		}

		if($tipo > 0) {
			$formato .= "AND tipo='%d' ";
			$argumentos[] = $tipo;
		}

		if($plato > 0) {
			$formato .= "AND plato='%d' ";
			$argumentos[] = $plato;
		}
		
		$formato .= "ORDER BY orden, plato LIMIT %d, %d";
		$argumentos[] = $inicio;
		$argumentos[] = $fin;
		
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_ordenes_platos = new OrdenPlato($this->conexion);
				$objeto_ordenes_platos->datos($lista['orden'], $lista['tipo'], $lista['plato']);
				$arreglo[] = $objeto_ordenes_platos;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de OrdenPlatos
	public function total_listado($orden=0, $tipo=0, $plato=0) {
		if(!is_int($orden = $this->seguridad->entero_seguro($orden))) {
			$this->error = "Orden no es Seguro";
			return false;
		}

		if(!is_int($tipo = $this->seguridad->entero_seguro($tipo))) {
			$this->error = "Tipo no es Seguro";
			return false;
		}

		if(!is_int($plato = $this->seguridad->entero_seguro($plato))) {
			$this->error = "Plato no es Seguro";
			return false;
		}
		
		$formato = "SELECT * FROM ordenes_platos WHERE 1=1 ";
		$argumentos = array();

		if($orden > 0) {
			$formato .= "AND orden='%d' ";
			$argumentos[] = $orden;
		}

		if($tipo > 0) {
			$formato .= "AND tipo='%d' ";
			$argumentos[] = $tipo;
		}

		if($plato > 0) {
			$formato .= "AND plato='%d' ";
			$argumentos[] = $plato;
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
