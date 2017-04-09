<?php
############################################
# - INICIA VARIABLE DE SESION              #
# - INCLUYE LAS VARIABLES DE CONFIGURACION #
# - ABRE LA CONEXION A LA BASE DE DATOS    #
############################################
header('Content-Type: text/html; charset=utf-8');

session_start();
require("variables.php");

// Conectar Base de Datos
$conexion = mysqli_connect($DBservidor, $DBusuario, $DBcontrasena, $DBnombre) or die("<p>No puede abrir la Base de Datos</p>".mysqli_error($conexion));

mysqli_set_charset($conexion, "utf8");

// Menú
$menu = array('class="active"', '', '', '');
$navegacion = array('', '', '');

if(!isset($_SESSION['zipcode'])) { $_SESSION['zipcode'] = ''; }

// Clases Obligatorias
require_once($GLOBALS['app_root']."/clases/clase_seguridad.php");
?>
