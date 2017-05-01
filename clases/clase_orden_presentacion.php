<?php
class OrdenPresentacion {
	########################################  Atributos  ########################################
	
	private $orden;
	private $producto;
	private $opcion1;
	private $opcion2;
	public  $precio;
	public  $cantidad;
	public  $instrucciones;
	private $conexion;
	private $seguridad;
	public  $error = NULL;
	
	#######################################  Operaciones  #######################################
	
	function __construct($conexion) {
		$this->error = NULL;
		$this->conexion = $conexion;
		$this->seguridad = new Seguridad($conexion);
	}
	
	// Insertar un OrdenPresentacion a la Base de Datos
	public function insertar($orden, $producto, $opcion1, $opcion2, $precio, $cantidad, $instrucciones) {
		if(!$orden = $this->seguridad->entero_seguro($orden)) {
			$this->error = "Orden no es Seguro";
			return false;
		}

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

		if(!$cantidad = $this->seguridad->entero_seguro($cantidad)) {
			$this->error = "Cantidad no es Seguro";
			return false;
		}

		if(!is_string($instrucciones = $this->seguridad->texto_seguro($this->conexion, $instrucciones))) {
			$this->error = "Instrucciones no es Seguro";
			return false;
		}
		
		$sql = sprintf("INSERT INTO ordenes_presentaciones(orden, producto, opcion1, opcion2, precio, cantidad, instrucciones) VALUES('%d', '%d', '%d', '%d', '%.2f', '%d', '%s')", $orden, $producto, $opcion1, $opcion2, $precio, $cantidad, $instrucciones);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Insertar";
			return false;
		}
	}
	
	// Eliminar un OrdenPresentacion de la Base de Datos ordenentificado por su orden
	public function eliminar($orden, $producto, $opcion1, $opcion2) {
		if(!$orden = $this->seguridad->entero_seguro($orden)) {
			$this->error = "Orden no es Seguro";
			return false;
		}

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
		
		$sql = sprintf("DELETE FROM ordenes_presentaciones WHERE orden='%d' AND producto='%d' AND opcion1='%d' AND opcion2='%d'", $orden, $producto, $opcion1, $opcion2);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Obtener datos de un OrdenPresentacion ordenentifiado por su orden
	public function datos($orden, $producto, $opcion1, $opcion2) {
		if(!$orden = $this->seguridad->entero_seguro($orden)) {
			$this->error = "Orden no es Seguro";
			return false;
		}

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
		
		$sql = sprintf("SELECT * FROM ordenes_presentaciones WHERE orden='%d' AND producto='%d' AND opcion1='%d' AND opcion2='%d'", $orden, $producto, $opcion1, $opcion2);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rordenes_presentaciones = mysqli_fetch_assoc($query)) {
				$this->orden = $rordenes_presentaciones['orden'];
				$this->producto = $rordenes_presentaciones['producto'];
				$this->opcion1 = $rordenes_presentaciones['opcion1'];
				$this->opcion2 = $rordenes_presentaciones['opcion2'];
				$this->precio = $rordenes_presentaciones['precio'];
				$this->cantidad = $rordenes_presentaciones['cantidad'];
				$this->instrucciones = $rordenes_presentaciones['instrucciones'];
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
	
	public function obtener_producto() {
		return $this->producto;
	}
	
	public function obtener_opcion1() {
		return $this->opcion1;
	}
	
	public function obtener_opcion2() {
		return $this->opcion2;
	}
	
	// Obtener listado de todos los OrdenPresentacions
	public function listado($orden=0, $producto=0, $opcion1=-1, $opcion2=-1) {
		if(!is_int($orden = $this->seguridad->entero_seguro($orden))) {
			$this->error = "Orden no es Seguro";
			return false;
		}

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
		
		$formato = "SELECT * FROM ordenes_presentaciones WHERE 1=1 ";
		$argumentos = array();

		if($orden > 0) {
			$formato .= "AND orden='%d' ";
			$argumentos[] = $orden;
		}

		if($producto > 0) {
			$formato .= "AND producto='%d' ";
			$argumentos[] = $producto;
		}

		if($opcion1 > -1) {
			$formato .= "AND opcion1='%d' ";
			$argumentos[] = $opcion1;
		}

		if($opcion2 > -1) {
			$formato .= "AND opcion2='%d' ";
			$argumentos[] = $opcion2;
		}
		
		$formato .= "ORDER BY orden, producto, opcion1";
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_ordenes_presentaciones = new OrdenPresentacion($this->conexion);
				$objeto_ordenes_presentaciones->datos($lista['orden'], $lista['producto'], $lista['opcion1'], $lista['opcion2']);
				$arreglo[] = $objeto_ordenes_presentaciones;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de todos los OrdenPresentacions paginados
	public function listado_paginado($orden=0, $producto=0, $opcion1=-1, $opcion2=-1, $inicio, $fin) {
		if(!is_int($orden = $this->seguridad->entero_seguro($orden))) {
			$this->error = "Orden no es Seguro";
			return false;
		}

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
			$this->error = "N&uacute;mero de Inicio no es Seguro";
			return false;
		}
		
		if(!is_int($fin = $this->seguridad->entero_seguro($fin))) {
			$this->error = "N&uacute;mero de Fin no es Seguro";
			return false;
		}
		
		$formato = "SELECT * FROM ordenes_presentaciones WHERE 1=1 ";
		$argumentos = array();

		if($orden > 0) {
			$formato .= "AND orden='%d' ";
			$argumentos[] = $orden;
		}

		if($producto > 0) {
			$formato .= "AND producto='%d' ";
			$argumentos[] = $producto;
		}

		if($opcion1 > -1) {
			$formato .= "AND opcion1='%d' ";
			$argumentos[] = $opcion1;
		}

		if($opcion2 > -1) {
			$formato .= "AND opcion2='%d' ";
			$argumentos[] = $opcion2;
		}
		
		$formato .= "ORDER BY orden, producto, opcion1 LIMIT %d, %d";
		$argumentos[] = $inicio;
		$argumentos[] = $fin;
		
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_ordenes_presentaciones = new OrdenPresentacion($this->conexion);
				$objeto_ordenes_presentaciones->datos($lista['orden'], $lista['producto'], $lista['opcion1'], $lista['opcion2']);
				$arreglo[] = $objeto_ordenes_presentaciones;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de OrdenPresentacions
	public function total_listado($orden=0, $producto=0, $opcion1=-1, $opcion2=-1) {
		if(!is_int($orden = $this->seguridad->entero_seguro($orden))) {
			$this->error = "Orden no es Seguro";
			return false;
		}

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
		
		$formato = "SELECT * FROM ordenes_presentaciones WHERE 1=1 ";
		$argumentos = array();

		if($orden > 0) {
			$formato .= "AND orden='%d' ";
			$argumentos[] = $orden;
		}

		if($producto > 0) {
			$formato .= "AND producto='%d' ";
			$argumentos[] = $producto;
		}

		if($opcion1 > -1) {
			$formato .= "AND opcion1='%d' ";
			$argumentos[] = $opcion1;
		}

		if($opcion2 > -1) {
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
