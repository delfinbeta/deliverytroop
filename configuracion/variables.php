<?php
#############################################################
#                VARIABLES DE CONFIGURACION:                #
# approot:       Ubicacion física de la aplicación          #
# domain_root:   Ubicacion HTTP de la aplicación            #
# DBservidor:    Nombre del servidor de bases de datos      #
# DBnombre:      Nombre de la base de datos                 #
# DBusuario:     Nombre de usuario de la base de datos      #
# DBcontrasena:  Contraseña del usuario de la base de datos #
#############################################################

################# Configuracion en Servidor #################
$GLOBALS['app_root'] = $_SERVER['DOCUMENT_ROOT'];
$GLOBALS['domain_root'] = "http://".$_SERVER['HTTP_HOST'];
$DBservidor = "45.40.164.17";
$DBnombre = "S3venDel";
$DBusuario = "S3venDel";
$DBcontrasena = "S3venDTj@ory";
$DBusuarioAdmin = "S3venDel";
$DBcontrasenaAdmin = "S3venDTj@ory";
$TIEMPO_MAXIMO_SESION = 3600;  // en segundos
$porcentaje_tax = 7; // Tax = 7%;
?>