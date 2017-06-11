<section class="compra">
	<div class="container">
		<form id="form_compra" class="form_compra" method="post">
			<div class="col-sm-6 col-md-2">
				<p><strong>Your info</strong></p>
				<a href="<?=$GLOBALS['domain_root']?>/hotels.php" class="btn btn-default boton-naranja1 col-xs-12"><i class="fa fa-bed" style="font-size: .8em;"></i> Staying in a hotel?</a>
			</div>
			<div class="col-sm-6 col-md-2 form-group">
				<label for="zipcode" class="control-label">Zipcode:</label>
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
					<input type="text" class="form-control" name="zipcode" value="<?=$_SESSION['orden']['zipcode']?>" placeholder="Zipcode" aria-describedby="bloqueErrorOZipcode" />
				</div>
				<span class="help-block" id="bloqueErrorOZipcode"></span>
			</div>
			<?php if($_SESSION['orden']['hotel_id'] > 0) { ?>
			<div class="col-sm-6 col-md-3 form-group">
				<label for="direccion" class="control-label">Address:</label>
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-building"></i></div>
					<input type="text" class="form-control" name="direccion" value="<?=$_SESSION['orden']['direccion']?>" readonly />
				</div>
				<span class="help-block" id="bloqueErrorODireccion"></span>
			</div>
			<div class="col-sm-6 col-md-3 form-group">
				<label for="direccion" class="control-label">Hotel:</label>
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-bed"></i></div>
					<input type="text" class="form-control" name="hotel_nombre" value="<?=$_SESSION['orden']['hotel_nombre']?>" readonly />
				</div>
			</div>
			<?php } else { ?>
			<div class="col-sm-6 form-group">
				<label for="direccion" class="control-label">Address:</label>
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-building"></i></div>
					<input type="text" class="form-control" name="direccion" value="<?=$_SESSION['orden']['direccion']?>" placeholder="Address" aria-describedby="bloqueErrorODireccion" />
				</div>
				<span class="help-block" id="bloqueErrorODireccion"></span>
			</div>
			<?php } ?>
			<div class="col-sm-6 col-md-2">
				<?php $items_compra = 0;
							$total_compra = 0;

							if(isset($_SESSION['orden']['pedido'])) {
								$items_compra = count($_SESSION['orden']['pedido']);
								
								if($items_compra > 0) {
									foreach($_SESSION['orden']['pedido'] as $item) {
										$total_compra += $item['cantidad'] * $item['precio'];
									}
								}
							} ?>
				<p class="text-right">
					<strong>Your Bag:</strong> <span class="badge"><?=$items_compra?></span> <span class="label label-success">  $<?=number_format($total_compra, 2)?></span>
				</p>
				<button type="submit" class="btn btn-default boton-naranja2 col-xs-12"><i class="fa fa-shopping-cart"></i> Checkout</button>
			</div>
		</form>
		<?php if(isset($_GET['msjH'])) { ?>
		<div class="row">
			<div class="col-xs-12 text-center">
				<div class="alert alert-success" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <i class="fa fa-check"></i> <span id="msjExito">Hotel Selected, now start your order from the options below.</span>
        </div>
			</div>
		</div>
		<?php } ?>
	</div>
</section>