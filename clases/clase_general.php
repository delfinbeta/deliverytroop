<?php
class General {
	########################################  Atributos  ########################################
	
	public $error;
	
	#######################################  Operaciones  #######################################
	
	function __construct() {
		$this->error = NULL;
	}
	
	function muestrafecha($fecha) {
		if((empty($fecha)) || ($fecha == "0000-00-00")) {
			$this->error = 'Fecha vacia';
			$resultado = '00-00-0000';
		} else {
			$resultado = date("d-m-Y", strtotime($fecha));
		}
		
		return $resultado;
	}
	
	function guardafecha($fecha) {
		$ano = substr ($fecha, 6, 4);
		$mes = substr ($fecha, 3, 2);
		$dia = substr ($fecha, 0, 2);
		$fecha = "$ano-$mes-$dia";
		
		if($fecha == '--') { $fecha = ''; }
		
		return $fecha;
	}
	
	function diferencia_entre_fechas($fecha1, $fecha2) {
		// separo la fecha
		$trozos1 = explode("-", $fecha1);
		$trozos2 = explode("-", $fecha2);
		
		//defino fecha 1
		$ano1 = $trozos1[0];
		$mes1 = $trozos1[1];
		$dia1 = $trozos1[2];
		
		//defino fecha 2
		$ano2 = $trozos2[0];
		$mes2 = $trozos2[1];
		$dia2 = $trozos2[2];
		
		//calculo timestam de las dos fechas
		$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
		$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2); 
		
		//resto a una fecha la otra
		$segundos_diferencia = $timestamp1 - $timestamp2;
		//echo $segundos_diferencia;
		
		//convierto segundos en días
		$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
		
		//obtengo el valor absoulto de los días (quito el posible signo negativo)
		//$dias_diferencia = abs($dias_diferencia);
		
		//quito los decimales a los días de diferencia
		$dias_diferencia = floor($dias_diferencia); 
		
		return $dias_diferencia;
	}
	
	function dia_semana($fecha) {
		list($ano,$mes,$dia) = explode("-",$fecha);
		$numero_dia_semana = date('w', mktime(0,0,0,$mes,$dia,$ano));
		
		switch($numero_dia_semana) {
			case 0: return "Domingo"; break;
			case 1: return "Lunes"; break;
			case 2: return "Martes"; break;
			case 3: return "Miércoles"; break;
			case 4: return "Jueves"; break;
			case 5: return "Viernes"; break;
			case 6: return "Sábado"; break;
		}
	}
	
	function dia_semana_actual() {
		$dia = date('w');
		switch($dia) {
			case 0: return "Domingo"; break;
			case 1: return "Lunes"; break;
			case 2: return "Martes"; break;
			case 3: return "Mi&eacute;rcoles"; break;
			case 4: return "Jueves"; break;
			case 5: return "Viernes"; break;
			case 6: return "S&aacute;bado"; break;
		}
	}
	
	function mes($fecha) {
		list($ano,$mes,$dia) = explode("-",$fecha);
		$numero_mes = date('m', mktime(0,0,0,$mes,$dia,$ano));
		
		switch($numero_mes) {
			case 1: return "Enero"; break;
			case 2: return "Febrero"; break;
			case 3: return "Marzo"; break;
			case 4: return "Abril"; break;
			case 5: return "Mayo"; break;
			case 6: return "Junio"; break;
			case 7: return "Julio"; break;
			case 8: return "Agosto"; break;
			case 9: return "Septiembre"; break;
			case 10: return "Octubre"; break;
			case 11: return "Noviembre"; break;
			case 12: return "Diciembre"; break;
		}
	}
	
	function mes_actual() {
		$mes = date('m');
		switch($mes) {
			case 1:  return "Enero"; break;
			case 2:  return "Febrero"; break;
			case 3:  return "Marzo"; break;
			case 4:  return "Abril"; break;
			case 5:  return "Mayo"; break;
			case 6:  return "Junio"; break;
			case 7:  return "Julio"; break;
			case 8:  return "Agosto"; break;
			case 9:  return "Septiembre"; break;
			case 10: return "Octubre"; break;
			case 11: return "Noviembre"; break;
			case 12: return "Diciembre"; break;
		}
	}
	
	function getUniqueCode($length = 8) {
		$code = md5(uniqid(rand(), true));
		if ($length != "") return substr($code, 0, $length);
		else return $code;
	}
	
	function generarCodigo($longitud=10, $caracter=TRUE, $numero=TRUE, $simbolo=FALSE) {
		$source = '';
		
		if($caracter) { $source .= 'a b c d e f g h i j k l m n o p q r s t u v w x y z A B C D E F G H I J K L M N O P Q R S T U V W X Y Z'; }
		
		if($numero) { $source .= '1 2 3 4 5 6 7 8 9 0'; }
		
		if($simbolo) { $source .= '| @ # ~ $ % ( ) = ^ * + [ ] { } - _'; }
		
		if($longitud > 0) {
			$codigo = "";		
			$source = explode(" ",$source);
			
			for($i = 0; $i < $longitud; $i++) {
				mt_srand((double)microtime() * 1000000);
				$num = mt_rand(1,count($source));
				$codigo .= $source[$num-1];
			}
		}
		
		return $codigo;
	}
	
	function ultimo_id($conexion) {
		return mysqli_insert_id($conexion);
	}
}
?>
