<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");

// Clases
require("../../clases/clase_orden.php");
require("../../clases/clase_orden_presentacion.php");
require("../../clases/clase_hotel.php");
require("../../clases/clase_producto.php");
require("../../clases/clase_opcion1.php");
require("../../clases/clase_opcion2.php");
require("../../clases/clase_general.php");

// Objetos
$orden = new Orden($conexion);
$orden_presentacion = new OrdenPresentacion($conexion);
$hotel = new Hotel($conexion);
$producto = new Producto($conexion);
$opcion1 = new Opcion1($conexion);
$opcion2 = new Opcion2($conexion);
$general = new General($conexion);

if(isset($_GET['id'])) { $id_orden = $_GET['id']; } else { $id_orden = 0; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Orders :: Delivery Troop</title>
	<meta name="description" content="Delivery Troop, On Demand Delivery Service" />
	<meta name="creator" content="www.delfinbeta.com.ve" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- Bootstrap -->
	<link rel="stylesheet" href="../../css/bootstrap.min.css" />
	<!-- Font-Awesome-4.7.0 -->
	<link rel="stylesheet" href="../../font-awesome-4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="../../css/admin.css" />
	<link rel="shortcut icon" href="../../img/favicon/favicon.ico" />
</head>
<body>
	<div class="container-fluid">
		<div class="row row-offcanvas row-offcanvas-left">
			<?php require("../../plantillas/menu_admin.php"); ?>
			<div class="col-sm-9 col-md-10 main">
				<div class="visible-xs">
					<button type="button" class="btn btn-warning btn-xs" data-toggle="offcanvas"><i class="fa fa-bars"></i> Menu</button>
				</div>
				<h1>Order</h1>
				<ol class="breadcrumb">
				  <li><a href="index.php">Orders</a></li>
				  <li class="active">Order</li>
				</ol>
				<?php if($orden->datos($id_orden)) { ?>
				<div class="well text-right">
					<?php if($orden->obtener_codEstado() == 1) { ?>
        	<button type="button" class="btn btn-info estatus" data-reg="<?=$orden->obtener_id()?>" data-estado="2"><i class="fa fa-usd"></i> Paid out</button>
        	<?php } ?>
        	<?php if($orden->obtener_codEstado() == 2) { ?>
        	<button type="button" class="btn btn-danger estatus" data-reg="<?=$orden->obtener_id()?>" data-estado="3"><i class="fa fa-usd"></i> Payment Reject</button>
        	<?php } ?>
        	<?php if($orden->obtener_codEstado() == 2) { ?>
        	<button type="button" class="btn btn-success estatus" data-reg="<?=$orden->obtener_id()?>" data-estado="4"><i class="fa fa-car"></i> Delivery</button>
        	<?php } ?>
        	<button type="button" class="btn btn-default imprimirBtn"><i class="fa fa-print"></i> Print</button>
				</div>
				<div id="area_impresion">
					<div class="panel panel-default">
						<div class="panel-heading">Customer Info:</div>
						<div class="panel-body">
	            <div class="row">
	            	<div class="col-md-6 col-sm-6 col-xs-12">
	          			<label># Order:</label>
	          			<?=str_pad($orden->obtener_id(), 8, "0", STR_PAD_LEFT)?>
	          		</div>
	            	<div class="col-md-6 col-sm-6 col-xs-12">
	            		<label>Date:</label>
	            		<?=$general->muestrafecha($orden->obtener_fecha_registro())?>
	            	</div>
	            </div>
	            <div class="row">
	            	<div class="col-md-6 col-sm-6 col-xs-12">
	            		<label>Name:</label>
	            		<?=$orden->nombre?>
	            	</div>
	            	<div class="col-md-6 col-sm-6 col-xs-12">
	            		<label>Email:</label>
	            		<?=$orden->email?>
	            	</div>
	            </div>
	            <div class="row">
	            	<div class="col-md-6 col-sm-6 col-xs-12">
	            		<label>Phone:</label>
	            		<?=$orden->telefono?>
	            	</div>
	            	<div class="col-md-6 col-sm-6 col-xs-12">
	            		<label>Address:</label>
	            		<?=$orden->direccion?>
	            	</div>
	            </div>
	            <div class="row">
	            	<div class="col-md-6 col-sm-6 col-xs-12">
	            		<label>Zipcode:</label>
	            		<?=$orden->zipcode?>
	            	</div>
	            	<div class="col-md-6 col-sm-6 col-xs-12">
	            		<label>City</label>
	            		<?=$orden->ciudad?>
	            	</div>
	            </div>
						</div>
					</div>
					<?php if($orden->obtener_hotel() > 0) { ?>
					<div class="panel panel-default">
						<div class="panel-heading">Hotel Info:</div>
						<div class="panel-body">
							<div class="row">
	            	<div class="col-md-6 col-sm-6 col-xs-12">
	            		<label>Hotel:</label>
	            		<?=$orden->hotel_nombre?>
	            	</div>
	            	<div class="col-md-6 col-sm-6 col-xs-12">
	            		<label>Room:</label>
	            		<?=$orden->hotel_habitacion?>
	            	</div>
	            </div>
						</div>
					</div>
					<?php } ?>
					<div class="panel panel-default">
						<div class="panel-heading">Instructions:</div>
						<div class="panel-body"><?=$orden->instrucciones?></div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">Bag:</div>
						<table class="table">
							<thead>
								<tr>
									<th width="80">&nbsp;</th>
									<th>Item</th>
									<th>Option 1</th>
									<th>Option 2</th>
									<th width="60" style="text-align: right;">Qty</th>
									<th width="100" style="text-align: right;">Price</th>
									<th width="100" style="text-align: right;">Subtotal</th>
								</tr>
							</thead>
							<?php // Listar Presentaciones
										$listado_presentaciones = $orden_presentacion->listado($id_orden, 0, -1, -1);
										$total_presentaciones = $orden_presentacion->total_listado($id_orden, 0, -1, -1);

										if($total_presentaciones > 0) { ?>
							<tbody>
								<?php $total = 0;
											foreach($listado_presentaciones as $item) {
												if($producto->datos($item->obtener_producto())) {
													$producto_img = "../../archivos_productos/".$producto->imagen;
													$producto_nombre = $producto->nombre;
												} else {
													$producto_img = '../../img/no_img.jpg';
													$producto_nombre = '---';
												}

												if($opcion1->datos($item->obtener_opcion1())) { $opcion1_nombre = $opcion1->nombre; }
												else { $opcion1_nombre = '---'; }

												if($opcion2->datos($item->obtener_opcion2())) { $opcion2_nombre = $opcion2->nombre; }
												else { $opcion2_nombre = '---'; }

												$subtotal = $item->precio * $item->cantidad;
												$total += $subtotal; ?>
								<tr>
									<td><img src="<?=$producto_img?>" alt="<?=$producto_nombre?>" title="<?=$producto_nombre?>" class="img-responsive center-block no_imprimir" /></td>
									<td>
										<strong><?=$producto_nombre?></strong>
										<?php if($item->instrucciones != '') { ?>
										<br />Special Instructions: <?=$item->instrucciones?>
										<?php } ?>
									</td>
									<td><?=$opcion1_nombre?></td>
									<td><?=$opcion2_nombre?></td>
									<td align="right"><?=$item->cantidad?></td>
									<td align="right">$<?=$item->precio?></td>
									<td align="right">$<?=number_format($subtotal, 2)?></td>
								</tr>
								<?php } ?>
								<tr>
									<td align="right" colspan="6"><strong>Subtotal</strong></td>
									<td align="right">$<?=number_format($total, 2)?></td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right" colspan="6"><strong>Delivery Fee</strong></td>
									<td align="right">$<?=$orden->delivery_fee?></td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right" colspan="6"><strong>Tax</strong></td>
									<td align="right">$<?=$orden->tax?></td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right" colspan="6"><strong>Tip</strong></td>
									<td align="right">$<?=$orden->propina?></td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right" colspan="6"><strong>Total</strong></td>
									<td align="right"><strong>$<?=$orden->total?></strong></td>
									<td>&nbsp;</td>
								</tr>
							</tbody>
							<?php } ?>
						</table>
					</div>
				</div>
				<?php } else { ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <i class="fa fa-times"></i> Error: <?=$orden->error?>
        </div>
        <?php } ?>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../../js/bootstrap.min.js"></script>
  <!-- PrintArea -->
  <script src="../../PrintArea-master/js/jquery.printarea.js"></script>
  <!-- Custom -->
  <script src="../../js/admin.js"></script>
  <script src="../../js/admin_orders.js"></script>
  <script>
  $(document).ready(function() {
    $(".imprimirBtn").click(function () {
      $("#area_impresion").printArea();
    });
  });
  </script>
</body>
</html>