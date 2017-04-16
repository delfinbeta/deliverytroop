<?php
class Hotel {
	########################################  Atributos  ########################################
	
	private $id;
	public  $nombre;
	public  $zipcode;
	public  $ciudad;
	public  $direccion;
	public  $imagen;
	public  $orden;
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
	
	// Insertar un Hotel a la Base de Datos
	public function insertar($nombre, $zipcode, $ciudad, $direccion, $imagen) {
		if(!$nombre = $this->seguridad->texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
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
		
		if(!$direccion = $this->seguridad->texto_seguro($this->conexion, $direccion)) {
			$this->error = "Direccion no es Seguro";
			return false;
		}
		
		if(!is_string($imagen = $this->seguridad->texto_seguro($this->conexion, $imagen))) {
			$this->error = "Imagen no es Seguro";
			return false;
		}
		
		$sql = sprintf("INSERT INTO hoteles(nombre, zipcode, ciudad, direccion, imagen, estado, fecha_registro) VALUES('%s', '%s', '%s', '%s', '%s', 1, CURDATE())", $nombre, $zipcode, $ciudad, $direccion, $imagen);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			$id_hotel = mysqli_insert_id($this->conexion);
			
			$sql2 = sprintf("UPDATE hoteles SET orden='%d' WHERE id='%d'", $id_hotel, $id_hotel);
			
			if($actualizo = mysqli_query($this->conexion, $sql2)) {
				return true;
			} else {
				$this->error = "No se puede Actualizar Orden";
				return false;
			}
		} else {
			$this->error = "No se puede Insertar";
			return false;
		}
	}
	
	// Actualizar un Hotel a la Base de Datos identificado por su id
	public function actualizar($id, $nombre, $zipcode, $ciudad, $direccion, $imagen) {
		if(!$nombre = $this->seguridad->texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
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
		
		if(!$direccion = $this->seguridad->texto_seguro($this->conexion, $direccion)) {
			$this->error = "Direccion no es Seguro";
			return false;
		}
		
		if(!is_string($imagen = $this->seguridad->texto_seguro($this->conexion, $imagen))) {
			$this->error = "Imagen no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE hoteles SET nombre='%s', zipcode='%s', ciudad='%s', direccion='%s', imagen='%s' WHERE id='%d'", $nombre, $zipcode, $ciudad, $direccion, $imagen, $id);
		
		if($actualizo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Modificar";
			return false;
		}
	}
	
	public function actualizar_orden($orden, $ordenamiento) {
		if(!is_int($orden = $this->seguridad->entero_seguro($orden))) {
			$this->error = "Orden no es Seguro";
			return false;
		}
		
		if(!is_string($ordenamiento = $this->seguridad->texto_seguro($this->conexion, $ordenamiento))) {
			$this->error = "Ordenamiento no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM hoteles WHERE orden='%d'", $orden);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($registro_actual = mysqli_fetch_assoc($query)) {
				if($ordenamiento == "a") {
					$accion = true;
					$orden_cambiar = $orden - 1;
					
					while($accion) {
						$sql2 = sprintf("SELECT * FROM hoteles WHERE orden='%d'", $orden_cambiar);
						
						if($query2 = mysqli_query($this->conexion, $sql2)) {
							if($rtmp = mysqli_fetch_assoc($query2)) {
								$accion = false;
							} else {
								$orden_cambiar--;
							}
						} else {
							$orden_cambiar--;
						}
					}
				} else {
					$accion = true;
					$orden_cambiar = $orden + 1;
					
					while($accion) {
						$sql2 = sprintf("SELECT * FROM hoteles WHERE orden='%d'", $orden_cambiar);
						
						if($query2 = mysqli_query($this->conexion, $sql2)) {
							if($rtmp = mysqli_fetch_assoc($query2)) {
								$accion = false;
							} else {
								$orden_cambiar++;
							}
						} else {
							$orden_cambiar++;
						}
					}
				}
				
				$sql2 = sprintf("SELECT * FROM hoteles WHERE orden='%d'", $orden_cambiar);
				
				if($query2 = mysqli_query($this->conexion, $sql2)) {
					if($registro_vecino = mysqli_fetch_assoc($query2)) {
						$sql3 = sprintf("UPDATE hoteles SET orden='%d' WHERE id='%d'", $orden_cambiar, $registro_actual['id']);
						
						if($query3 = mysqli_query($this->conexion, $sql3)) {
							$sql3 = sprintf("UPDATE hoteles SET orden='%d' WHERE id='%d'", $orden, $registro_vecino['id']);
							
							if($query3 = mysqli_query($this->conexion, $sql3)) {
								return true;
							} else {
								$this->error = "No se puede Actualizar Registro Vecino";
								return false;
							}
						} else {
							$this->error = "No se puede Actualizar Registro Actual";
							return false;
						}
					} else {
						$this->error = "No se puede consultar Orden Nuevo";
						return false;
					}
				} else {
					$this->error = "No se puede consultar Orden Nuevo";
					return false;
				}
			} else {
				$this->error = "ID no aroja resultados";
				return false;
			}
		} else {
			$this->error = "No se puede consultar Orden";
			return false;
		}
	}
	
	// Eliminar un Hotel de la Base de Datos identificado por su id
	private function eliminar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM hoteles WHERE id='%d'", $id);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Desactivar un Hotel de la Base de Datos identificado por su id
	public function desactivar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE hoteles SET estado=0 WHERE id='%d'", $id);
		
		if($desactivo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar (D)";
			return false;
		}
	}
	
	// Obtener datos de un Hotel identifiado por su id
	public function datos($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM hoteles WHERE id='%d'", $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rhotel = mysqli_fetch_assoc($query)) {
				$this->id = $rhotel['id'];
				$this->nombre = $rhotel['nombre'];
				$this->zipcode = $rhotel['zipcode'];
				$this->ciudad = $rhotel['ciudad'];
				$this->direccion = $rhotel['direccion'];
				$this->imagen = $rhotel['imagen'];
				$this->orden = $rhotel['orden'];
				$this->estado = $rhotel['estado'];
				$this->fecha_registro = $rhotel['fecha_registro'];
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
	
	// Obtener listado de todos los Hotels
	public function listado($zipcode='', $estado=-1) {
		if(!is_string($zipcode = $this->seguridad->texto_seguro($this->conexion, $zipcode))) {
			$this->error = "Zipcode no es Seguro";
			return false;
		}

		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM hoteles WHERE 1=1 ";
		$argumentos = array();

		if($zipcode != '') {
			$formato .= "AND zipcode='%s' ";
			$argumentos[] = $zipcode;
		}
		
		if($estado == -1) {
			$formato .= "AND estado!=0 ";
		} else {
			$formato .= "AND estado='%d' ";
			$argumentos[] = $estado;
		}
		
		$formato .= "ORDER BY orden";
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_zipcode = new Hotel($this->conexion);
				$objeto_zipcode->datos($lista['id']);
				$arreglo[] = $objeto_zipcode;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de todos los Hotels paginados
	public function listado_paginado($zipcode='', $estado=-1, $inicio, $fin) {
		if(!is_string($zipcode = $this->seguridad->texto_seguro($this->conexion, $zipcode))) {
			$this->error = "Zipcode no es Seguro";
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
		
		$formato = "SELECT id FROM hoteles WHERE 1=1 ";
		$argumentos = array();

		if($zipcode != '') {
			$formato .= "AND zipcode='%s' ";
			$argumentos[] = $zipcode;
		}
		
		if($estado == -1) {
			$formato .= "AND estado!=0 ";
		} else {
			$formato .= "AND estado='%d' ";
			$argumentos[] = $estado;
		}
		
		$formato .= "ORDER BY orden LIMIT %d, %d";
		$argumentos[] = $inicio;
		$argumentos[] = $fin;
		
		$sql = vsprintf($formato, $argumentos);
		
		$arreglo = array();
		if($query = mysqli_query($this->conexion, $sql)) {
			while($lista = mysqli_fetch_assoc($query)) {
				$objeto_zipcode = new Hotel($this->conexion);
				$objeto_zipcode->datos($lista['id']);
				$arreglo[] = $objeto_zipcode;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de Hotels
	public function total_listado($zipcode='', $estado=-1) {
		if(!is_string($zipcode = $this->seguridad->texto_seguro($this->conexion, $zipcode))) {
			$this->error = "Zipcode no es Seguro";
			return false;
		}

		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM hoteles WHERE 1=1 ";
		$argumentos = array();

		if($zipcode != '') {
			$formato .= "AND zipcode='%s' ";
			$argumentos[] = $zipcode;
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
	
	// Verificar si imagen ya existe
	public function imagen_existe($imagen, $id) {
		if(!$imagen = $this->seguridad->texto_seguro($this->conexion, $imagen)) {
			$this->error = "Imagen no es Seguro";
			return false;
		}
		
		if(!is_int($id = $this->seguridad->entero_seguro($id))) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM hoteles WHERE imagen='%s' AND id!='%d' AND estado!=0", $imagen, $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rbanner1 = mysqli_fetch_assoc($query)) { return true; }
			else { return false; }
		} else {
			return false;
		}
	}
	
	// Cargar archivo de la imagen
	public function cargar_archivo($nombre_archivo, $temporal) {
		if($nombre_archivo != "") {
			$ruta = $GLOBALS['app_root']."/archivos_hoteles/".$nombre_archivo;
			
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
}
?>