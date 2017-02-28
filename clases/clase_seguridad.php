<?php
class Seguridad {
	########################################  Atributos  ########################################
	
	public $error;
	
	#######################################  Operaciones  #######################################
	
	function __construct() {
		$this->error = NULL;
	}
		
	public function texto_seguro($conexion, $texto) {
		if(is_string($texto)) {
			if(get_magic_quotes_gpc()) {
				$texto_nuevo = stripslashes($texto);
				$texto_nuevo = mysqli_real_escape_string($conexion, $texto_nuevo);
			} else {
				$texto_nuevo = mysqli_real_escape_string($conexion, $texto);
			}
			
			return $texto_nuevo;
		} else {
			return false;
		}
	}
	
	public function entero_seguro($numero) {
		if(is_numeric($numero)) {
			return intval($numero);
		} else {
			return false;
		}
	}
	
	public function float_seguro($numero) {
		if(is_numeric($numero)) {
			return floatval($numero);
		} else {
			return false;
		}
	}
}
?>
