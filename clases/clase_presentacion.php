<?php
class Presentacion {
	########################################  Atributos  ########################################
	
	private $producto;
	private $opcion1;
	private $opcion2;
	public  $precio;
	private $conexion;
	private $seguridad;
	public  $error = NULL;
	
	#######################################  Operaciones  #######################################
	
	function __construct($conexion) {
		$this->error = NULL;
		$this->conexion = $conexion;
		$this->seguridad = new Seguridad($conexion);
	}
	
	// Insertar un Presentacion a la Base de Datos
	public function insertar($producto, $opcion1, $opcion2, $precio) {
		if(!$producto = $this->seguridad->entero_seguro($producto)) {
			$this->error = "Producto no es Seguro";
			return false;
		}

		if(!is_int($opcion1 = $this->seguridad->entero_seguro($opcion1))) {
			$this->error = "Opcion 1 no es Seguro";
			return false;
		}

		if(!is_int($opcion2 = $this->seguridad->entero_seguro($opcion2))) {
			$this->error = "Opcion 2 no es Seguro";
			return false;
		}
		
		if(!is_float($precio = $this->seguridad->float_seguro($precio))) {
			$this->error = "Precio no es Seguro";
			return false;
		}
		
		$sql = sprintf("INSERT INTO presentaciones(producto, opcion1, opcion2, precio) VALUES('%d', '%d', '%d', '%.2f')", $producto, $opcion1, $opcion2, $precio);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Insertar";
			return false;
		}
	}
	
	// Eliminar un Presentacion de la Base de Datos identificado por su id
	public function eliminar($producto, $opcion1, $opcion2) {
		if(!$producto = $this->seguridad->entero_seguro($producto)) {
			$this->error = "Producto no es Seguro";
			return false;
		}

		if(!is_int($opcion1 = $this->seguridad->entero_seguro($opcion1))) {
			$this->error = "Opcion 1 no es Seguro";
			return false;
		}

		if(!is_int($opcion2 = $this->seguridad->entero_seguro($opcion2))) {
			$this->error = "Opcion 2 no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM presentaciones WHERE producto='%d' AND opcion1='%d' AND opcion2='%d'", $producto, $opcion1, $opcion2);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Obtener datos de un Presentacion identifiado por su id
	public function datos($producto, $opcion1, $opcion2) {
		if(!$producto = $this->seguridad->entero_seguro($producto)) {
			$this->error = "Producto no es Seguro";
			return false;
		}

		if(!is_int($opcion1 = $this->seguridad->entero_seguro($opcion1))) {
			$this->error = "Opcion 1 no es Seguro";
			return false;
		}

		if(!is_int($opcion2 = $this->seguridad->entero_seguro($opcion2))) {
			$this->error = "Opcion 2 no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM presentaciones WHERE producto='%d' AND opcion1='%d' AND opcion2='%d'", $producto, $opcion1, $opcion2);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rpresentacion = mysqli_fetch_assoc($query)) {
				$this->producto = $rpresentacion['producto'];
				$this->opcion1 = $rpresentacion['opcion1'];
				$this->opcion2 = $rpresentacion['opcion2'];
				$this->precio = $rpresentacion['precio'];
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
	
	public function obtener_producto() {
		return $this->producto;
	}
	
	public function obtener_opcion1() {
		return $this->opcion1;
	}
	
	public function obtener_opcion2() {
		return $this->opcion2;
	}

	// Obtener Precio Minimo de una Presentacion identifiado por su Producto
	public function precio_minimo($producto) {
		if(!$producto = $this->seguridad->entero_seguro($producto)) {
			$this->error = "Producto no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT MIN(precio) AS precio FROM presentaciones WHERE producto='%d'", $producto);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rpresentacion = mysqli_fetch_assoc($query)) {
				return $rpresentacion['precio'];
			} else {
				$this->error = "ID no aroja resultados";
				return 0;
			}
		} else {
			$this->error = "No se puede consultar ID";
			return 0;
		}
	}
	
	// Obtener listado de todos los Presentaciones
	public function listado($producto=0, $opcion1=0, $opcion2=0) {
		if(!is_int($producto = $this->seguridad->entero_seguro($producto))) {
			$this->error = "Producto no es Seguro";
			return false;
		}

		if(!is_int($opcion1 = $this->seguridad->entero_seguro($opcion1))) {
			$this->error = "Opcion 1 no es Seguro";
			return false;
		}

		if(!is_int($opcion2 = $this->seguridad->entero_seguro($opcion2))) {
			$this->error = "Opcion 2 no es Seguro";
			return false;
		}
		
		$formato = "SELECT * FROM presentaciones WHERE 1=1 ";
		$argumentos = array();
		
		if($producto > 0) {
			$formato .= "AND producto='%d' ";
			$argumentos[] = $producto;
		}
		
		if($opcion1 > 0) {
			$formato .= "AND opcion1='%d' ";
			$argumentos[] = $opcion1;
		}
		
		if($opcion2 > 0) {
			$formato .= "AND opcion2='%d' ";
			$argumentos[] = $opcion2;
		}
		
		$formato .= "ORDER BY producto, opcion1";
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_presentacion = new Presentacion($this->conexion);
				$objeto_presentacion->datos($lista['producto'], $lista['opcion1'], $lista['opcion2']);
				$arreglo[] = $objeto_presentacion;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de todos los Presentacions paginados
	public function listado_paginado($producto=0, $opcion1=0, $opcion2=0, $inicio, $fin) {
		if(!is_int($producto = $this->seguridad->entero_seguro($producto))) {
			$this->error = "Producto no es Seguro";
			return false;
		}

		if(!is_int($opcion1 = $this->seguridad->entero_seguro($opcion1))) {
			$this->error = "Opcion 1 no es Seguro";
			return false;
		}

		if(!is_int($opcion2 = $this->seguridad->entero_seguro($opcion2))) {
			$this->error = "Opcion 2 no es Seguro";
			return false;
		}
		
		if(!is_int($inicio = $this->seguridad->entero_seguro($inicio))) {
			$this->error = "Número de Inicio no es Seguro";
			return false;
		}
		
		if(!is_int($fin = $this->seguridad->entero_seguro($fin))) {
			$this->error = "Número de Fin no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM presentaciones WHERE 1=1 ";
		$argumentos = array();
		
		if($producto > 0) {
			$formato .= "AND producto='%d' ";
			$argumentos[] = $producto;
		}
		
		if($opcion1 > 0) {
			$formato .= "AND opcion1='%d' ";
			$argumentos[] = $opcion1;
		}
		
		if($opcion2 > 0) {
			$formato .= "AND opcion2='%d' ";
			$argumentos[] = $opcion2;
		}
		
		$formato .= "ORDER BY producto, opcion1 LIMIT %d, %d";
		$argumentos[] = $inicio;
		$argumentos[] = $fin;
		
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_presentacion = new Presentacion($this->conexion);
				$objeto_presentacion->datos($lista['producto'], $lista['opcion1'], $lista['opcion2']);
				$arreglo[] = $objeto_presentacion;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de Presentacions
	public function total_listado($producto=0, $opcion1=0, $opcion2=0) {
		if(!is_int($producto = $this->seguridad->entero_seguro($producto))) {
			$this->error = "Producto no es Seguro";
			return false;
		}

		if(!is_int($opcion1 = $this->seguridad->entero_seguro($opcion1))) {
			$this->error = "Opcion 1 no es Seguro";
			return false;
		}

		if(!is_int($opcion2 = $this->seguridad->entero_seguro($opcion2))) {
			$this->error = "Opcion 2 no es Seguro";
			return false;
		}
		
		$formato = "SELECT * FROM presentaciones WHERE 1=1 ";
		$argumentos = array();
		
		if($producto > 0) {
			$formato .= "AND producto='%d' ";
			$argumentos[] = $producto;
		}
		
		if($opcion1 > 0) {
			$formato .= "AND opcion1='%d' ";
			$argumentos[] = $opcion1;
		}
		
		if($opcion2 > 0) {
			$formato .= "AND opcion2='%d' ";
			$argumentos[] = $opcion2;
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
