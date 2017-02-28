<?php
class Extra extends Seguridad {
	########################################  Atributos  ########################################
	
	private $id;
	private $categoria;
	public  $nombre;
	public  $precio;
	public  $resumen;
	public  $descripcion;
	public  $recomendado;
	public  $imagen;
	public  $orden;
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
	
	// Insertar un Extra a la Base de Datos
	public function insertar($categoria, $nombre, $precio, $resumen, $descripcion, $recomendado, $imagen) {
		if(!$categoria = parent::entero_seguro($categoria)) {
			$this->error = "Categoria no es Seguro";
			return false;
		}

		if(!$nombre = parent::texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}

		if(!is_float($precio = parent::float_seguro($precio))) {
			$this->error = "Precio no es Seguro";
			return false;
		}

		if(!is_string($resumen = parent::texto_seguro($this->conexion, $resumen))) {
			$this->error = "Descripción Corta no es Seguro";
			return false;
		}

		if(!is_string($descripcion = parent::texto_seguro($this->conexion, $descripcion))) {
			$this->error = "Descripcion no es Seguro";
			return false;
		}

		if(!is_int($recomendado = parent::entero_seguro($recomendado))) {
			$this->error = "Recomendado no es Seguro";
			return false;
		}

		if(!is_string($imagen = parent::texto_seguro($this->conexion, $imagen))) {
			$this->error = "Imagen no es Seguro";
			return false;
		}
		
		$sql = sprintf("INSERT INTO extras(categoria, nombre, precio, resumen, descripcion, recomendado, imagen, estado, fecha_registro, usuario_registro, fecha_actualizacion, usuario_actualizacion) VALUES('%d', '%s', '%f', '%s', '%s', '%d', '%s', 1, CURDATE(), '%d', CURDATE(), '%d')", $categoria, $nombre, $precio, $resumen, $descripcion, $recomendado, $imagen, $_SESSION['usuario_id'], $_SESSION['usuario_id']);
		
		if($inserto = mysqli_query($this->conexion, $sql)) {
			$id_categoria = mysqli_insert_id($this->conexion);
			
			$sql2 = sprintf("UPDATE extras SET orden='%d' WHERE id='%d'", $id_categoria, $id_categoria);
			
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
	
	// Actualizar un Extra a la Base de Datos identificado por su id
	public function actualizar($id, $nombre, $precio, $resumen, $descripcion, $recomendado, $imagen) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}

		if(!$nombre = parent::texto_seguro($this->conexion, $nombre)) {
			$this->error = "Nombre no es Seguro";
			return false;
		}

		if(!is_float($precio = parent::float_seguro($precio))) {
			$this->error = "Precio no es Seguro";
			return false;
		}

		if(!is_string($resumen = parent::texto_seguro($this->conexion, $resumen))) {
			$this->error = "Descripción Corta no es Seguro";
			return false;
		}

		if(!is_string($descripcion = parent::texto_seguro($this->conexion, $descripcion))) {
			$this->error = "Descripcion no es Seguro";
			return false;
		}

		if(!is_int($recomendado = parent::entero_seguro($recomendado))) {
			$this->error = "Recomendado no es Seguro";
			return false;
		}

		if(!is_string($imagen = parent::texto_seguro($this->conexion, $imagen))) {
			$this->error = "Imagen no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE extras SET nombre='%s', precio='%f', resumen='%s', descripcion='%s', recomendado='%d', imagen='%s', fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='%d'", $nombre, $precio, $resumen, $descripcion, $recomendado, $imagen, $_SESSION['usuario_id'], $id);
		
		if($actualizo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Modificar";
			return false;
		}
	}
	
	public function actualizar_orden($orden, $ordenamiento) {
		if(!is_int($orden = parent::entero_seguro($orden))) {
			$this->error = "Orden no es Seguro";
			return false;
		}
		
		if(!is_string($ordenamiento = parent::texto_seguro($this->conexion, $ordenamiento))) {
			$this->error = "Ordenamiento no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM extras WHERE orden='%d'", $orden);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($registro_actual = mysqli_fetch_assoc($query)) {
				if($ordenamiento == "a") {
					$accion = true;
					$orden_cambiar = $orden - 1;
					
					while($accion) {
						$sql2 = sprintf("SELECT * FROM extras WHERE orden='%d'", $orden_cambiar);
						
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
						$sql2 = sprintf("SELECT * FROM extras WHERE orden='%d'", $orden_cambiar);
						
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
				
				$sql2 = sprintf("SELECT * FROM extras WHERE orden='%d'", $orden_cambiar);
				
				if($query2 = mysqli_query($this->conexion, $sql2)) {
					if($registro_vecino = mysqli_fetch_assoc($query2)) {
						$sql3 = sprintf("UPDATE extras SET orden='%d' WHERE id='%d'", $orden_cambiar, $registro_actual['id']);
						
						if($query3 = mysqli_query($this->conexion, $sql3)) {
							$sql3 = sprintf("UPDATE extras SET orden='%d' WHERE id='%d'", $orden, $registro_vecino['id']);
							
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
	
	// Eliminar un Extra de la Base de Datos identificado por su id
	private function eliminar($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("DELETE FROM extras WHERE id='%d'", $id);
		
		if($elimino = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar";
			return false;
		}
	}
	
	// Desactivar un Extra de la Base de Datos identificado por su id
	public function desactivar($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("UPDATE extras SET estado=0, fecha_actualizacion=CURDATE(), usuario_actualizacion='%d' WHERE id='%d'", $_SESSION['usuario_id'], $id);
		
		if($desactivo = mysqli_query($this->conexion, $sql)) {
			return true;
		} else {
			$this->error = "No se puede Eliminar (D)";
			return false;
		}
	}
	
	// Obtener datos de un Extra identifiado por su id
	public function datos($id) {
		if(!$id = parent::entero_seguro($id)) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM extras WHERE id='%d'", $id);
		
		if($query = mysqli_query($this->conexion, $sql)) {
			if($rextra = mysqli_fetch_assoc($query)) {
				$this->id = $rextra['id'];
				$this->categoria = $rextra['categoria'];
				$this->nombre = $rextra['nombre'];
				$this->precio = $rextra['precio'];
				$this->resumen = $rextra['resumen'];
				$this->descripcion = $rextra['descripcion'];
				$this->recomendado = $rextra['recomendado'];
				$this->imagen = $rextra['imagen'];
				$this->orden = $rextra['orden'];
				$this->estado = $rextra['estado'];
				$this->fecha_registro = $rextra['fecha_registro'];
				$this->usuario_registro = $rextra['usuario_registro'];
				$this->fecha_actualizacion = $rextra['fecha_actualizacion'];
				$this->usuario_actualizacion = $rextra['usuario_actualizacion'];
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
	
	public function obtener_categoria() {
		return $this->categoria;
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
	
	// Obtener listado de todos los Extras
	public function listado($categoria=0, $recomendado=-1, $estado=-1) {
		if(!is_int($categoria = parent::entero_seguro($categoria))) {
			$this->error = "Categoria no es Seguro";
			return false;
		}
		
		if(!is_int($recomendado = parent::entero_seguro($recomendado))) {
			$this->error = "Recomendado no es Seguro";
			return false;
		}
		
		if(!is_int($estado = parent::entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM extras WHERE 1=1 ";
		$argumentos = array();

		if($categoria > 0) {
			$formato .= "AND categoria='%d' ";
			$argumentos[] = $categoria;
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
				$objeto_plato = new Extra($this->conexion);
				$objeto_plato->datos($lista['id']);
				$arreglo[] = $objeto_plato;
			}
		}
		
		return $arreglo;
	}
	
	// Obtener listado de todos los Extras paginados
	public function listado_paginado($categoria=0, $recomendado=-1, $estado=-1, $inicio, $fin) {
		if(!is_int($categoria = parent::entero_seguro($categoria))) {
			$this->error = "Categoria no es Seguro";
			return false;
		}
		
		if(!is_int($recomendado = parent::entero_seguro($recomendado))) {
			$this->error = "Recomendado no es Seguro";
			return false;
		}
		
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
		
		$formato = "SELECT id FROM extras WHERE 1=1 ";
		$argumentos = array();

		if($categoria > 0) {
			$formato .= "AND categoria='%d' ";
			$argumentos[] = $categoria;
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
				$objeto_plato = new Extra($this->conexion);
				$objeto_plato->datos($lista['id']);
				$arreglo[] = $objeto_plato;
			}
		}
		
		return $arreglo;
	}
	
	// Contar el total de Extras
	public function total_listado($categoria=0, $recomendado=-1, $estado=-1) {
		if(!is_int($categoria = parent::entero_seguro($categoria))) {
			$this->error = "Categoria no es Seguro";
			return false;
		}
		
		if(!is_int($recomendado = parent::entero_seguro($recomendado))) {
			$this->error = "Recomendado no es Seguro";
			return false;
		}
		
		if(!is_int($estado = parent::entero_seguro($estado))) {
			$this->error = "Estado no es Seguro";
			return false;
		}
		
		$formato = "SELECT id FROM extras WHERE 1=1 ";
		$argumentos = array();

		if($categoria > 0) {
			$formato .= "AND categoria='%d' ";
			$argumentos[] = $categoria;
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
		if(!$imagen = parent::texto_seguro($this->conexion, $imagen)) {
			$this->error = "Imagen no es Seguro";
			return false;
		}
		
		if(!is_int($id = parent::entero_seguro($id))) {
			$this->error = "ID no es Seguro";
			return false;
		}
		
		$sql = sprintf("SELECT * FROM extras WHERE imagen='%s' AND id!='%d' AND estado!=0", $imagen, $id);
		
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
			$ruta = $GLOBALS['app_root']."/archivos_extras/".$nombre_archivo;
			
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