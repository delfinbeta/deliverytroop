<?php
require("configuracion/inicio.php");

$menu[0] = '';
$menu[3] = 'class="active"';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Contact :: Delivery Troop</title>
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
			<h1>Contact</h1>
			<hr class="separador2" />
			<div class="row contacto2">
				<div class="col-md-6">
					<div class="text-center info">
						<a href="mailto:hello@deliverytroop.com">
							<i class="icono fa fa-envelope"></i>
							hello@deliverytroop.com
						</a>
					</div>
					<div class="text-center info">
						<a href="tel:+17546107181">
							<i class="icono fa fa-phone"></i>
							+1 754 610 7181
						</a>
					</div>
					<div class="text-center">
						<p class="info">Your questions, comments and suggestions help us bring you the tastiest food and the best service we can. Please get in touch, even if just to say hi!</p>
					</div>
				</div>
				<div class="col-md-6">
					<form id="form_contact" class="form_contact" method="post">
						<div id="exito" class="alert alert-success hidden" role="alert">
		          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		          <i class="fa fa-check"></i> <span id="msjExito">Exito</span>
		        </div>
		        <div id="error" class="alert alert-danger hidden" role="alert">
		          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		          <i class="fa fa-times"></i> <span id="msjError">Error</span>
		        </div>
						<div class="row">
							<div class="col-xs-12 col-sm-6 form-group">
								<label for="nombre" class="control-label sr-only">Name</label>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-user"></i></div>
									<input type="text" class="form-control" name="nombre" placeholder="Name" aria-describedby="bloqueErrorNombre" />
								</div>
								<span class="help-block" id="bloqueErrorNombre"></span>
							</div>
							<div class="col-xs-12 col-sm-6 form-group">
								<label for="email" class="control-label sr-only">Email</label>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
									<input type="email" class="form-control" name="email" placeholder="Email" aria-describedby="bloqueErrorEmail" />
								</div>
								<span class="help-block" id="bloqueErrorEmail"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 form-group">
								<label for="mensaje" class="control-label sr-only" aria-describedby="bloqueErrorMensaje">Message</label>
								<textarea name="mensaje" cols="30" rows="6" class="form-control" placeholder="Message"></textarea>
								<span class="help-block" id="bloqueErrorMensaje"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<button type="submit" name="enviar" class="btn btn-default boton-amarillo2 col-xs-12"><i class="fa fa-envelope"></i> Send Message</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

	<?php require("plantillas/contacto.php"); ?>
	<?php require("plantillas/piepag.php"); ?>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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