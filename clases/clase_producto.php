<?php
class Producto {
	########################################  Atributos  ########################################
	
	private $id;
	private $restaurante;
	public  $nombre;
	public  $resumen;
	public  $descripcion;
	public  $recomendado;
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
	
	// Insertar un Producto a la Base de Datos
	public function insertar($restaurante, $nombre, $resumen, $descripcion, $recomendado, $imagen) {
		if(!$restaurante = $this->seguridad->entero_seguro($restaurante)) {
			$this->error = "Restaurante no es Seguro";
			return false;
		}

		if(!$nombre = $this->seguridad->texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}

		if(!is_string($resumen = $this->seguridad->texto_seguro($this->conexion, $resumen))) {
			$this->error = "Descripción Corta no es Seguro";
			return false;
		}

		if(!is_string($descripcion = $this->seguridad->texto_seguro($this->conexion, $descripcion))) {
			$this->error = "Descripcion no es Seguro";
			return false;
		}

		if(!is_int($recomendado = $this->seguridad->entero_seguro($recomendado))) {
			$this->error = "Recomendado no es Seguro";
			return false;
		}

		if(!is_string($imagen = $this->seguridad->texto_seguro($this->conexion, $imagen))) {
			$this->error = "Imagen no es Seguro";
			return false;
		}
		
		$sql = sprintf("INSERT INTO productos(restaurante, nombre, resumen, descripcion, recomendado, imagen, estado, fecha_registro) VALUES('%d', '%s', '%s', '%s', '%d', '%s', 1, CURDATE())", $restaurante, $nombre, $resumen, $descripcion, $recomendado, $imagen);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			$id_restaurante = mysqli_insert_id($this->conexion);
			
			$sql2 = sprintf("UPDATE productos SET orden='%d' WHERE id='%d'", $id_restaurante, $id_restaurante);
			
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
	
	// Actualizar un Producto a la Base de Datos identificado por su id
	public function actualizar($id, $restaurante, $nombre, $resumen, $descripcion, $recomendado, $imagen) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}

		if(!$restaurante = $this->seguridad->entero_seguro($restaurante)) {
			$this->error = "Restaurante no es Seguro";
			return false;
		}

		if(!$nombre = $this->seguridad->texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}

		if(!is_string($resumen = $this->seguridad->texto_seguro($this->conexion, $resumen))) {
			$this->error = "Descripción Corta no es Seguro";
			return false;
		}

		if(!is_string($descripcion = $this->seguridad->texto_seguro($this->conexion, $descripcion))) {
			$this->error = "Descripcion no es Seguro";
			return false;
		}

		if(!is_int($recomendado = $this->seguridad->entero_seguro($recomendado))) {
			$this->error = "Recomendado no es Seguro";
			return false;
		}

		if(!is_string($imagen = $this->seguridad->texto_seguro($this->conexion, $imagen))) {
			$this->error = "Imagen no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE productos SET restaurante='%d', nombre='%s', resumen='%s', descripcion='%s', recomendado='%d', imagen='%s' WHERE id='%d'", $restaurante, $nombre, $resumen, $descripcion, $recomendado, $imagen, $id);
		
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
		
		$sql = sprintf("SELECT * FROM productos WHERE orden='%d'", $orden);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($registro_actual = mysqli_fetch_assoc($query)) {
				if($ordenamiento == "a") {
					$accion = true;
					$orden_cambiar = $orden - 1;
					
					while($accion) {
						$sql2 = sprintf("SELECT * FROM productos WHERE orden='%d'", $orden_cambiar);
						
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
						$sql2 = sprintf("SELECT * FROM productos WHERE orden='%d'", $orden_cambiar);
						
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
				
				$sql2 = sprintf("SELECT * FROM productos WHERE orden='%d'", $orden_cambiar);
				
				if($query2 = mysqli_query($this->conexion, $sql2)) {
					if($registro_vecino = mysqli_fetch_assoc($query2)) {
						$sql3 = sprintf("UPDATE productos SET orden='%d' WHERE id='%d'", $orden_cambiar, $registro_actual['id']);
						
						if($query3 = mysqli_query($this->conexion, $sql3)) {
							$sql3 = sprintf("UPDATE productos SET orden='%d' WHERE id='%d'", $orden, $registro_vecino['id']);
							
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
	
	// Eliminar un Producto de la Base de Datos identificado por su id
	private function eliminar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM productos WHERE id='%d'", $id);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Desactivar un Producto de la Base de Datos identificado por su id
	public function desactivar($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE productos SET estado=0 WHERE id='%d'", $id);
		
		if($desactivo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar (D)";
			return false;
		}
	}
	
	// Obtener datos de un Producto identifiado por su id
	public function datos($id) {
		if(!$id = $this->seguridad->entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM productos WHERE id='%d'", $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rproducto = mysqli_fetch_assoc($query)) {
				$this->id = $rproducto['id'];
				$this->restaurante = $rproducto['restaurante'];
				$this->nombre = $rproducto['nombre'];
				$this->resumen = $rproducto['resumen'];
				$this->descripcion = $rproducto['descripcion'];
				$this->recomendado = $rproducto['recomendado'];
				$this->imagen = $rproducto['imagen'];
				$this->orden = $rproducto['orden'];
				$this->estado = $rproducto['estado'];
				$this->fecha_registro = $rproducto['fecha_registro'];
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
	
	public function obtener_restaurante() {
		return $this->restaurante;
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
	
	// Obtener listado de todos los Productos
	public function listado($restaurante=0, $recomendado=-1, $estado=-1) {
		if(!is_int($restaurante = $this->seguridad->entero_seguro($restaurante))) {
			$this->error = "Restaurante no es Seguro";
			return false;
		}
		
		if(!is_int($recomendado = $this->seguridad->entero_seguro($recomendado))) {
			$this->error = "Recomendado no es Seguro";
			return false;
		}
		
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM productos WHERE 1=1 ";
		$argumentos = array();

		if($restaurante > 0) {
			$formato .= "AND restaurante='%d' ";
			$argumentos[] = $restaurante;
		}

		if($recomendado > -1) {
			$formato .= "AND recomendado='%d' ";
			$argumentos[] = $recomendado;
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
				$objeto_producto = new Producto($this->conexion);
				$objeto_producto->datos($lista['id']);
				$arreglo[] = $objeto_producto;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de todos los Productos paginados
	public function listado_paginado($restaurante=0, $recomendado=-1, $estado=-1, $inicio, $fin) {
		if(!is_int($restaurante = $this->seguridad->entero_seguro($restaurante))) {
			$this->error = "Restaurante no es Seguro";
			return false;
		}
		
		if(!is_int($recomendado = $this->seguridad->entero_seguro($recomendado))) {
			$this->error = "Recomendado no es Seguro";
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
		
		$formato = "SELECT id FROM productos WHERE 1=1 ";
		$argumentos = array();

		if($restaurante > 0) {
			$formato .= "AND restaurante='%d' ";
			$argumentos[] = $restaurante;
		}

		if($recomendado > -1) {
			$formato .= "AND recomendado='%d' ";
			$argumentos[] = $recomendado;
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
				$objeto_producto = new Producto($this->conexion);
				$objeto_producto->datos($lista['id']);
				$arreglo[] = $objeto_producto;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de Productos
	public function total_listado($restaurante=0, $recomendado=-1, $estado=-1) {
		if(!is_int($restaurante = $this->seguridad->entero_seguro($restaurante))) {
			$this->error = "Restaurante no es Seguro";
			return false;
		}
		
		if(!is_int($recomendado = $this->seguridad->entero_seguro($recomendado))) {
			$this->error = "Recomendado no es Seguro";
			return false;
		}
		
		if(!is_int($estado = $this->seguridad->entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM productos WHERE 1=1 ";
		$argumentos = array();

		if($restaurante > 0) {
			$formato .= "AND restaurante='%d' ";
			$argumentos[] = $restaurante;
		}

		if($recomendado > -1) {
			$formato .= "AND recomendado='%d' ";
			$argumentos[] = $recomendado;
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
		
		$sql = sprintf("SELECT * FROM productos WHERE imagen='%s' AND id!='%d' AND estado!=0", $imagen, $id);
		
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
			$ruta = $GLOBALS['app_root']."/archivos_productos/".$nombre_archivo;
			
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
