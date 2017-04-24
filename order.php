<?php
require("configuracion/inicio.php");

// Clases
require("clases/clase_producto.php");
require("clases/clase_opcion1.php");
require("clases/clase_opcion2.php");

// Objetos
$producto = new Producto($conexion);
$opcion1 = new Opcion1($conexion);
$opcion2 = new Opcion2($conexion);

$menu[0] = '';
$menu[2] = 'class="active"';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Order :: Delivery Troop</title>
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
	<?php require("plantillas/navegacion.php"); ?>

	<section class="franja-gris">
		<div class="container">
			<h1>Order</h1>
			<hr class="separador2" />
			<div id="exito" class="alert alert-success hidden" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <i class="fa fa-check"></i> <span id="msjExito">Exito</span>
      </div>
			<form id="form_order" class="form_order" method="post">
        <div id="error" class="alert alert-danger hidden" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <i class="fa fa-times"></i> <span id="msjError">Error</span>
        </div>
        <input type="hidden" name="hotel_id" value="<?=$_SESSION['orden']['hotel_id']?>" />
				<fieldset>
					<legend>Your Info</legend>
					<div class="row">
						<div class="col-xs-12 col-sm-6 form-group">
							<label for="nombre" class="control-label sr-only">Name</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-user"></i></div>
								<input type="text" class="form-control" name="nombre" placeholder="Name" value="<?=$_SESSION['orden']['nombre']?>" aria-describedby="bloqueErrorNombre" />
							</div>
							<span class="help-block" id="bloqueErrorNombre"></span>
						</div>
						<div class="col-xs-12 col-sm-6 form-group">
							<label for="email" class="control-label sr-only">Email</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
								<input type="email" class="form-control" name="email" placeholder="Email" value="<?=$_SESSION['orden']['email']?>" aria-describedby="bloqueErrorEmail" />
							</div>
							<span class="help-block" id="bloqueErrorEmail"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6 form-group">
							<label for="telefono" class="control-label sr-only">Phone</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-phone"></i></div>
								<input type="text" class="form-control" name="telefono" placeholder="Phone" value="<?=$_SESSION['orden']['telefono']?>" aria-describedby="bloqueErrorTelefono" />
							</div>
							<span class="help-block" id="bloqueErrorTelefono"></span>
						</div>
						<div class="col-xs-12 col-sm-6 form-group">
							<label for="direccion" class="control-label sr-only">Address</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-building"></i></div>
								<input type="text" class="form-control" name="direccion" placeholder="Address" value="<?=$_SESSION['orden']['direccion']?>" aria-describedby="bloqueErrorDireccion" />
							</div>
							<span class="help-block" id="bloqueErrorDireccion"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6 form-group">
							<label for="zipcode" class="control-label sr-only">Zipcode</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
								<input type="text" class="form-control" name="zipcode" placeholder="Zipcode" value="<?=$_SESSION['orden']['zipcode']?>" aria-describedby="bloqueErrorZipcode" />
							</div>
							<span class="help-block" id="bloqueErrorZipcode"></span>
						</div>
						<div class="col-xs-12 col-sm-6 form-group">
							<label for="ciudad" class="control-label sr-only">City</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-globe"></i></div>
								<input type="text" class="form-control" name="ciudad" placeholder="City" value="<?=$_SESSION['orden']['ciudad']?>" aria-describedby="bloqueErrorCiudad" />
							</div>
							<span class="help-block" id="bloqueErrorCiudad"></span>
						</div>
					</div>
				</fieldset>
				<?php if($_SESSION['orden']['hotel_id'] != '') { ?>
				<fieldset>
					<legend>Hotel</legend>
					<div class="row">
						<div class="col-xs-12 col-sm-6 form-group">
							<label for="hotel_nombre" class="control-label sr-only">Hotel</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-bed"></i></div>
								<input type="text" class="form-control" name="hotel_nombre" placeholder="Hotel" value="<?=$_SESSION['orden']['hotel_nombre']?>" aria-describedby="bloqueErrorHotel" />
							</div>
							<span class="help-block" id="bloqueErrorHotel"></span>
						</div>
						<div class="col-xs-12 col-sm-6 form-group">
							<label for="habitacion" class="control-label sr-only">Room</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-bell"></i></div>
								<input type="text" class="form-control" name="habitacion" placeholder="Room" value="<?=$_SESSION['orden']['habitacion']?>" aria-describedby="bloqueErrorHabitacion" />
							</div>
							<span class="help-block" id="bloqueErrorHabitacion"></span>
						</div>
					</div>
				</fieldset>
				<?php } ?>
				<fieldset>
					<legend>Instructions</legend>
					<div class="row">
						<div class="col-xs-12 form-group">
							<label for="instrucciones" class="control-label sr-only">Instructions</label>
							<textarea name="instrucciones" class="form-control" cols="30" rows="6" placeholder="Delivery Instructions" aria-describedby="bloqueErrorInstrucciones"><?=$_SESSION['orden']['instrucciones']?></textarea>
							<span class="help-block" id="bloqueErrorInstrucciones"></span>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend>Your Bag</legend>
					<?php if(isset($_SESSION['orden']['pedido']) && (count($_SESSION['orden']['pedido']) > 0)) { ?>
					<div class="table-responsive">
						<table id="tabla-pedido" class="table">
							<thead>
								<tr>
									<th width="80">&nbsp;</th>
									<th>Item</th>
									<th>Option 1</th>
									<th>Option 2</th>
									<th width="60" style="text-align: right;">Qty</th>
									<th width="100" style="text-align: right;">Price</th>
									<th width="100" style="text-align: right;">Subtotal</th>
									<th width="20">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php $subtotal = 0;
											$total = 0;
											foreach($_SESSION['orden']['pedido'] as $item) {
												if($producto->datos($item['producto'])) {
													$producto_img = "archivos_productos/".$producto->imagen;
													$producto_nombre = $producto->nombre;
												} else {
													$producto_img = 'img/no_img.jpg';
													$producto_nombre = '---';
												}

												if($opcion1->datos($item['opcion1'])) { $opcion1_nombre = $opcion1->nombre; } else { $opcion1_nombre = '---'; }
												if($opcion2->datos($item['opcion2'])) { $opcion2_nombre = $opcion2->nombre; } else { $opcion2_nombre = '---'; }

												$subtotal = $item['cantidad'] * $item['precio'];
												$total += $subtotal; ?>
								<tr>
									<td><img src="<?=$producto_img?>" alt="<?=$producto_nombre?>" title="<?=$producto_nombre?>" class="img-responsive center-block" /></td>
									<td>
										<strong><?=$producto_nombre?></strong>
										<?php if($item['instrucciones'] != '') { ?>
										<br />Special Instructions: <?=$item['instrucciones']?>
										<?php } ?>
									</td>
									<td><?=$opcion1_nombre?></td>
									<td><?=$opcion2_nombre?></td>
									<td align="right"><?=$item['cantidad']?></td>
									<td align="right">$<?=$item['precio']?></td>
									<td align="right">$<?=number_format($subtotal, 2)?></td>
									<td><a href="#" class="eliminar-pedido" data-pos="<?=$item['posicion']?>"><i class="icono fa fa-remove"></i></a></td>
								</tr>
								<?php }
											
											$subtotal = $total;

											$delivery_fee = 0;

											// Definir costo de Tax (Impuesto)
											$tax = ($subtotal * $porcentaje_tax) / 100;

											// Definir Total
											$total = $subtotal + $delivery_fee + $tax; ?>
								<tr>
									<td align="right" colspan="6"><strong>Subtotal</strong></td>
									<td align="right">$<?=number_format($subtotal, 2)?></td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right" colspan="6"><strong>Delivery Fee</strong></td>
									<td align="right">$<?=number_format($delivery_fee, 2)?></td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right" colspan="6"><strong>Tax</strong></td>
									<td align="right">$<?=number_format($tax, 2)?></td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right" colspan="6"><strong>Total</strong></td>
									<td align="right"><strong>$<?=number_format($total, 2)?></strong></td>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</div>
					<?php } else { ?>
					<p>You currently do not have any items. Please add items to your cart before checking out.</p>
					<?php } ?>
				</fieldset>
				<button type="submit" class="btn btn-default boton-naranja2 col-xs-12 col-md-6 col-md-offset-3"><i class="fa fa-shopping-cart"></i> Checkout</button>
			</form>
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