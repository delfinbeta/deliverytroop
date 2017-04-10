<?php
require("configuracion/inicio.php");

// Clases
require("clases/clase_zipcode.php");
require("clases/clase_restaurante.php");
require("clases/clase_producto.php");

// Objetos
$zipcode = new Zipcode($conexion);
$restaurante = new Restaurante($conexion);
$producto = new Producto($conexion);

if(!$zipcode->datos2($_SESSION['zipcode'])) { header("location: index.php"); }

if(isset($_GET['id'])) { $id_restaurante = $_GET['id']; } else { $id_restaurante = 0; }

if(!$restaurante->datos($id_restaurante)) { header("location: index.php"); }

$hora_servidor = date("H:i:s");
$hora_servidor = date("H:i:s", strtotime("-5 hours")); // Hora en Weston
$hora_servidor = strtotime($hora_servidor);
$hora_inicio = strtotime($restaurante->hora_inicio);
$hora_fin = strtotime($restaurante->hora_fin);

if(($hora_servidor < $hora_inicio) || ($hora_servidor > $hora_fin)) { header("location: index.php"); }

$menu[0] = '';
$menu[2] = 'class="active"';

if($restaurante->imagen != '') { $restaurante_img = "archivos_restaurantes/".$restaurante->imagen; }
else { $restaurante_img = "img/no_img.jpg"; }

// Listar Productos
$listado_productos = $producto->listado($id_restaurante, -1, 1);
$total_productos = $producto->total_listado($id_restaurante, -1, 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?=$restaurante->nombre?> :: Delivery Troop</title>
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
			<h1><?=$restaurante->nombre?></h1>
			<hr class="separador2" />
			<div class="row restaurante">
				<div class="col-md-2">
					<img src="<?=$restaurante_img?>" alt="<?=$reg_restaurante->nombre?>" title="<?=$reg_restaurante->nombre?>" class="img-responsive center-block" />
				</div>
				<div class="col-md-10">
					<h3><?=$restaurante->nombre?></h3>
					<p>Restaurant hours: <?=date("h:i a", strtotime($restaurante->hora_inicio))?> - <?=date("h:i a", strtotime($restaurante->hora_fin))?></p>
					<p><?=$restaurante->direccion?></p>
					<p>Estimated delivery time: 20-40min.</p>
				</div>
			</div>
			<hr class="separador2" />
			<?php if($total_productos > 0) { ?>
			<div class="row">
				<?php foreach($listado_productos as $reg_producto) {
								if($reg_producto->imagen != '') { $producto_img = "archivos_productos/".$reg_producto->imagen; }
								else { $producto_img = "img/no_img.jpg"; } ?>
				<div class="col-sm-6 col-md-3">
					<article class="producto-grilla">
						<div class="imagen">
							<img src="<?=$producto_img?>" alt="<?=$reg_producto->nombre?>" title="<?=$reg_producto->nombre?>" class="img-responsive center-block" />
							<button type="button" class="boton_foto" name="ordenar" data-id="<?=$reg_producto->obtener_id()?>" data-nombre="<?=$reg_producto->nombre?>">Order Now</button>
						</div>
						<div class="info">
							<div class="titulo"><?=$reg_producto->nombre?></div>
							<div class="precio">$00.00</div>
							<div class="resumen">
								<?=$reg_producto->resumen?><br />
								<a href="food.php?id=<?=$reg_producto->obtener_id()?>">More Details</a>
							</div>
						</div>
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