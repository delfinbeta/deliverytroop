<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Administración :: 7Delivery ::</title>
	<meta name="description" content="SupraBT" />
	<meta name="creator" content="www.tecnod20.com" />
	<meta name="viewport" content="width=device-width, intial-scale=1.0" />
	<meta name="distribution" content="global" />
	<meta name="revisit-after" content="1 days" />
	<meta http-equiv="imagetoolbar" content="no" />

	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	<link rel="shortcut icon" href="../favicon.ico" />
</head>
<body>
	<?php if($_SESSION['error'] == 1) { ?>
	<script language="javascript" type="text/javascript">
	  alert("¡Usted debe Iniciar Sesión!");
	  location.href = "../index.php";
	</script>
	<?php } ?>

	<?php if($_SESSION['error'] == 2) { ?>
	<script language="javascript" type="text/javascript">
	  alert("¡Usted pasó mucho tiempo inactivo!");
	  location.href = "salida.php";
	</script>
	<?php } ?>

	<?php if($_SESSION['error'] == 3) { ?>
	<script language="javascript" type="text/javascript">
	  alert("¡Usted no tiene permisos suficientes!");
	  location.href = "salida.php";
	</script>
	<?php } ?>
</body>
</html>