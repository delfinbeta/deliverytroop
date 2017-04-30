<?php
class Orden {
	########################################  Atributos  ########################################
	
	private $id;
	public  $nombre;
	public  $email;
	public  $telefono;
	public  $direccion;
	public  $zipcode;
	public  $ciudad;
	public  $instrucciones;
	private $hotel_id;
	public  $hotel_nombre;
	public  $hotel_habitacion;
	public  $delivery_fee;
	public  $tax;
	public  $propina;
	public  $total;
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
	
	// Insertar un Orden a la Base de Datos
	public function insertar($nombre, $email, $telefono, $direccion, $zipcode, $ciudad, $instrucciones, $hotel_id, $hotel_nombre, $hotel_habitacion, $delivery_fee, $tax, $propina, $total) {
		if(!$nombre = $this->seguridad->texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}

		if(!$email = $this->seguridad->texto_seguro($this->conexion, $email)) {
			$this->error = "Email no es Seguro";
			return false;
		}

		if(!$telefono = $this->seguridad->texto_seguro($this->conexion, $telefono)) {
			$this->error = "Telefono no es Seguro";
			return false;
		}

		if(!$direccion = $this->seguridad->texto_seguro($this->conexion, $direccion)) {
			$this->error = "Direccion no es Seguro";
			return false;
		}

		if(!$zipcode = $this->seguridad->texto_seguro($this->conexion, $zipcode)) {
			$this->error = "Zipcode no es Seguro";
			return false;
		}

		if(!$ciudad = $this->seguridad->texto_seguro($this->conexion, $ciudad)) {
			$this->error = "Ciudad no es Seguro";
			return false;
		}

		if(!is_string($instrucciones = $this->seguridad->texto_seguro($this->conexion, $instrucciones))) {
			$this->error = "Instrucciones no es Seguro";
			return false;
		}

		if(!is_int($hotel_id = $this->seguridad->entero_seguro($hotel_id))) {
			$this->error = "Hotel ID no es Seguro";
			return false;
		}

		if(!is_string($hotel_nombre = $this->seguridad->texto_seguro($this->conexion, $hotel_nombre))) {
			$this->error = "Hotel Nombre no es Seguro";
			return false;
		}

		if(!is_string($hotel_habitacion = $this->seguridad->texto_seguro($this->conexion, $hotel_habitacion))) {
			$this->error = "Hotel Habitacion no es Seguro";
			return false;
		}

		if(!is_float($delivery_fee = $this->seguridad->float_seguro($delivery_fee))) {
			$this->error = "Delivery Fee no es Seguro";
			return false;
		}

		if(!is_float($tax = $this->seguridad->float_seguro($tax))) {
			$this->error = "Tax no es Seguro";
			return false;
		}

		if(!is_float($propina = $this->seguridad->float_seguro($propina))) {
			$this->error = "Propina no es Seguro";
			return false;
		}

		if(!is_float($total = $this->seguridad->float_seguro($total))) {
			$this->error = "Total no es Seguro";
			return false;
		}
		
		$sql = sprintf("INSERT INTO ordenes(nombre, email, telefono, direccion, zipcode, ciudad, instrucciones, hotel_id, hotel_nombre, hotel_habitacion, delivery_fee, tax, propina, total, estado, fecha_registro) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%f', '%f', '%f', '%f', 1, CURDATE())", $nombre, $email, $telefono, $direccion, $zipcode, $ciudad, $instrucciones, $hotel_id, $hotel_nombre, $hotel_habitacion, $delivery_fee, $tax, $propina, $total);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Insertar";
			return false;
		}
	}
	
	// Cambiar Estado de una Orden de la Base de Datos identificado por su id
	public function actualizar_estado($id, $estado) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}

		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE ordenes SET estado='%d' WHERE id='%d'", $estado, $id);
		
		if($desactivo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Actualizar Estado";
			return false;
		}
	}
	
	// Eliminar un Orden de la Base de Datos identificado por su id
	private function eliminar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM ordenes WHERE id='%d'", $id);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Desactivar un Orden de la Base de Datos identificado por su id
	public function desactivar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE ordenes SET estado=0 WHERE id='%d'", $id);
		
		if($desactivo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar (D)";
			return false;
		}
	}
	
	// Obtener datos de un Orden identifiado por su id
	public function datos($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM ordenes WHERE id='%d'", $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rorden = mysqli_fetch_assoc($query)) {
				$this->id = $rorden['id'];
				$this->nombre = $rorden['nombre'];
				$this->email = $rorden['email'];
				$this->telefono = $rorden['telefono'];
				$this->direccion = $rorden['direccion'];
				$this->zipcode = $rorden['zipcode'];
				$this->ciudad = $rorden['ciudad'];
				$this->instrucciones = $rorden['instrucciones'];
				$this->hotel_id = $rorden['hotel_id'];
				$this->hotel_nombre = $rorden['hotel_nombre'];
				$this->hotel_habitacion = $rorden['hotel_habitacion'];
				$this->delivery_fee = $rorden['delivery_fee'];
				$this->tax = $rorden['tax'];
				$this->propina = $rorden['propina'];
				$this->total = $rorden['total'];
				$this->estado = $rorden['estado'];
				$this->fecha_registro = $rorden['fecha_registro'];
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
	
	public function obtener_hotel() {
		return $this->hotel;
	}
	
	public function obtener_codEstado() {
		return $this->estado;
	}
	
	public function obtener_estado() {
		switch($this->estado) {
			case 0: $estado = "Eliminado"; break;
			case 1: $estado = "Pendiente"; break;
			case 2: $estado = "Pagado"; break;
			case 3: $estado = "Pago Rechazado"; break;
			case 4: $estado = "Despachado"; break;
			default: $estado = "---"; break;
		}
		
		return $estado;
	}
	
	public function obtener_fecha_registro() {
		return $this->fecha_registro;
	}
	
	// Obtener listado de Ordenes
	public function listado($nombre='', $email='', $hotel=-1, $estado=-1) {
		if(!is_string($nombre = $this->seguridad->texto_seguro($this->conexion, $nombre))) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		if(!is_string($email = $this->seguridad->texto_seguro($this->conexion, $email))) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!is_int($hotel = $this->seguridad->entero_seguro($hotel))) {
			$this->error = "Hotel no es Seguro";
			return false;
		}
		
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM ordenes WHERE 1=1 ";
		$argumentos = array();
		
		if($nombre != '') {
			$formato .= "AND nombre LIKE %%%s%% ";
			$argumentos[] = $nombre;
			$argumentos[] = $nombre;
		}
		
		if($email != '') {
			$formato .= "AND email='%s' ";
			$argumentos[] = $email;
		}
		
		if($hotel > -1) {
			$formato .= "AND hotel_id='%d' ";
			$argumentos[] = $hotel;
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
				$objeto_orden = new Orden($this->conexion);
				$objeto_orden->datos($lista['id']);
				$arreglo[] = $objeto_orden;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de Ordenes Paginado
	public function listado_paginado($nombre='', $email='', $hotel=-1, $estado=-1, $inicio, $fin) {
		if(!is_string($nombre = $this->seguridad->texto_seguro($this->conexion, $nombre))) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		if(!is_string($email = $this->seguridad->texto_seguro($this->conexion, $email))) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!is_int($hotel = $this->seguridad->entero_seguro($hotel))) {
			$this->error = "Hotel no es Seguro";
			return false;
		}
		
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
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
		
		$formato = "SELECT id FROM ordenes WHERE 1=1 ";
		$argumentos = array();
		
		if($nombre != '') {
			$formato .= "AND nombre LIKE %%%s%% ";
			$argumentos[] = $nombre;
			$argumentos[] = $nombre;
		}
		
		if($email != '') {
			$formato .= "AND email='%s' ";
			$argumentos[] = $email;
		}
		
		if($hotel > -1) {
			$formato .= "AND hotel_id='%d' ";
			$argumentos[] = $hotel;
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
				$objeto_orden = new Orden($this->conexion);
				$objeto_orden->datos($lista['id']);
				$arreglo[] = $objeto_orden;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de Ordenes Listados
	public function total_listado($nombre='', $email='', $hotel=-1, $estado=-1) {
		if(!is_string($nombre = $this->seguridad->texto_seguro($this->conexion, $nombre))) {
			$this->error = "Nombre no es Seguro";
			return false;
		}
		
		if(!is_string($email = $this->seguridad->texto_seguro($this->conexion, $email))) {
			$this->error = "Email no es Seguro";
			return false;
		}
		
		if(!is_int($hotel = $this->seguridad->entero_seguro($hotel))) {
			$this->error = "Hotel no es Seguro";
			return false;
		}
		
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM ordenes WHERE 1=1 ";
		$argumentos = array();
		
		if($nombre != '') {
			$formato .= "AND nombre LIKE %%%s%% ";
			$argumentos[] = $nombre;
			$argumentos[] = $nombre;
		}
		
		if($email != '') {
			$formato .= "AND email='%s' ";
			$argumentos[] = $email;
		}
		
		if($hotel > -1) {
			$formato .= "AND hotel_id='%d' ";
			$argumentos[] = $hotel;
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
