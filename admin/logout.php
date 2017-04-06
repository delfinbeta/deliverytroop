<?php
session_start();                 // Comienza la sesion
session_unset();                 // Vacia las variables de sesion
session_destroy();               // Destruye la sesion

header("location: index.php");
?>