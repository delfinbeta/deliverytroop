<?php
require("configuracion/inicio.php");

$menu[0] = '';
$menu[2] = 'class="active"';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Restaurants :: Delivery Troop</title>
	<meta name="description" content="Delivery Troop, On Demand Delivery Service" />
	<meta name="creator" content="www.delfinbeta.com.ve" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<!-- Font-Awesome-4.7.0 -->
	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="css/deliverytroop.css" />
	<link rel="shortcut icon" href="img/favicon/favicon.ico" />
</head>
<body>
	<?php require("plantillas/menu.php"); ?>
	<?php require("plantillas/encabezado.php"); ?>

	<section class="franja-gris">
		<div class="container">
			<h1>Restaurants</h1>
			<hr class="separador2" />
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore nostrum quae sit dicta consequuntur cumque, asperiores fugit! Reiciendis sed soluta, sequi itaque. Quisquam tempora blanditiis quod maxime sequi incidunt beatae.</p>
		</div>
	</section>

	<?php require("plantillas/contacto.php"); ?>
	<?php require("plantillas/piepag.php"); ?>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.min.js"></script>
  <!-- Google Analytics -->
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62920042-1', 'auto');
  ga('send', 'pageview');
  </script>
</body>
</html>