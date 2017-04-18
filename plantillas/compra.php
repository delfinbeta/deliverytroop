<section class="compra">
	<div class="container">
		<form id="form_compra" class="form_compra" method="post">
			<div class="col-sm-6 col-md-2">
				<p><strong>Your info</strong></p>
				<a href="<?=$GLOBALS['domain_root']?>/hotels.php" class="btn btn-default boton-naranja1 col-xs-12"><i class="fa fa-bed" style="font-size: .8em;"></i> I'm staying at a hotel</a>
			</div>
			<div class="col-sm-6 col-md-2 form-group">
				<label for="zipcode" class="control-label">Zipcode:</label>
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
					<input type="text" class="form-control" name="zipcode" value="<?=$_SESSION['orden']['zipcode']?>" placeholder="Zipcode" aria-describedby="bloqueErrorOZipcode" />
				</div>
				<span class="help-block" id="bloqueErrorOZipcode"></span>
			</div>
			<div class="col-sm-6 form-group">
				<label for="direccion" class="control-label">Address:</label>
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-building"></i></div>
					<input type="text" class="form-control" name="direccion" value="<?=$_SESSION['orden']['direccion']?>" placeholder="Address" aria-describedby="bloqueErrorODireccion" />
				</div>
				<span class="help-block" id="bloqueErrorODireccion"></span>
			</div>
			<div class="col-sm-6 col-md-2">
				<p>&nbsp;</p>
				<button type="submit" class="btn btn-default boton-naranja2 col-xs-12"><i class="fa fa-shopping-cart"></i> Checkout</button>
			</div>
		</form>
	</div>
</section>