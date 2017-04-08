<?php require("configuracion/inicio.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Delivery Troop</title>
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

	<section class="portada">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
					<a href="<?=$GLOBALS['domain_root']?>/index.php"><img src="img/DeliveryTroop.svg" alt="Delivery Troop" title="Delivery Troop" class="img-responsive logo" /></a>
					<p class="eslogan">On Demand Delivery Service</p>

					<form id="form_zipcode" name="form_zipcode" method="post">
						<div class="form-group">
							<label for="zipcode" class="control-label sr-only">Zipcode</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-map-marker" style="font-size: 1.4em;"></i></div>
								<input type="text" class="form-control" name="zipcode" value="<?=$_SESSION['zipcode']?>" placeholder="Zipcode" aria-describedby="bloqueErrorZipcode" />
								<span class="input-group-btn">
									<button type="submit" name="enviar" class="btn btn-default boton-amarillo">Enter Your Zipcode <i class="fa fa-chevron-right"></i></button>
								</span>
							</div>
							<span class="help-block" id="bloqueErrorZipcode"></span>
						</div>
					</form>

					<p>Delivery Hours: Every day 11:30am - 11:30pm</p>
				</div>
			</div>
		</div>
	</section>

	<section class="home">
		<div class="container">
			<p align="center">Delivery Troop is the service that gives you the ability to shop from local merchants or restaurants.</p>
			<p align="center">Food Delivery / Dry Cleaning / Beverages / Pharmacy / and more...</p>
			<p align="center">Delivered in under an hour 7 Days a Week!</p>
		</div>
	</section>

	<section class="franja-gris">
		<div class="container">
			<p>&nbsp;</p>
		</div>
	</section>

	<section class="contacto">
		<div class="container text-center">
			<h2>Contact Us</h2>
			<hr class="separador" />
			<div class="row">
				<div class="col-sm-6">
					<a href="mailto:hello@deliverytroop.com">
						<i class="icono fa fa-envelope"></i>
						hello@deliverytroop.com
					</a>
				</div>
				<div class="col-sm-6">
					<a href="tel:+17546107181">
						<i class="icono fa fa-phone"></i>
						+1 754 610 7181
					</a>
				</div>
			</div>
			<p class="info">Want to order form multiple restaurants? No problem! Need to feed a large group and you don't want to hassle with cooking, picking up and preparing, or paying inflated prices for a full service caterer? We got you. Hotel guest looking for better options then overpriced room service? We're on it</p>
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
						<textarea name="mensaje" cols="30" rows="8" class="form-control" placeholder="Message"></textarea>
						<span class="help-block" id="bloqueErrorMensaje"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<button type="submit" name="enviar" class="btn btn-default boton-amarillo"><i class="fa fa-envelope"></i> Send Message</button>
					</div>
				</div>
			</form>
		</div>
	</section>

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