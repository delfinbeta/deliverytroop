<?php
require("configuracion/inicio.php");

// Clases
require("clases/clase_zipcode.php");
require("clases/clase_hotel.php");
require("clases/clase_categoria.php");

// Objetos
$zipcode = new Zipcode($conexion);
$hotel = new Hotel($conexion);

if(!$zipcode->datos2($_SESSION['orden']['zipcode'])) { header("location: index.php"); }

$menu[0] = '';
$menu[2] = 'class="active"';

// Listar Hoteles
$listado_hoteles = $hotel->listado($_SESSION['orden']['zipcode'], 1);
$total_hoteles = $hotel->total_listado($_SESSION['orden']['zipcode'], 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Hotels :: Delivery Troop</title>
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
	<?php require("plantillas/compra.php"); ?>
	<?php require("plantillas/navegacion.php"); ?>

	<section class="franja-gris">
		<div class="container">
			<h1>Hotels</h1>
			<hr class="separador2" />
			<?php if($total_hoteles > 0) { ?>
			<div class="row">
				<?php foreach($listado_hoteles as $reg_hotel) {
								if($reg_hotel->imagen != '') { $hotel_img = "archivos_hoteles/".$reg_hotel->imagen; }
								else { $hotel_img = "img/no_img.jpg"; } ?>
				<div class="col-sm-6 col-md-3">
					<article class="restaurante-grilla">
						<a href="#" class="hotel" data-id="<?=$reg_hotel->obtener_id()?>"><img src="<?=$hotel_img?>" alt="<?=$reg_hotel->nombre?>" title="<?=$reg_hotel->nombre?>" class="img-responsive center-block" /></a>
					</article>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
	</section>

	<?php require("plantillas/contacto.php"); ?>
	<?php require("plantillas/piepag.php"); ?>

	<!-- jQuery -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
	<script src="js/jquery-1.10.2.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.min.js"></script>
  <!-- Custom -->
  <script src="js/deliverytroop.js"></script>
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