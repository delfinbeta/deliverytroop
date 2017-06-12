<?php
require("configuracion/inicio.php");

// Clases
require("clases/clase_zipcode.php");
require("clases/clase_categoria.php");
require("clases/clase_producto.php");
require("clases/clase_presentacion.php");

// Objetos
$zipcode = new Zipcode($conexion);
$categoria = new Categoria($conexion);
$producto = new Producto($conexion);
$presentacion = new Presentacion($conexion);

if(!$zipcode->datos2($_SESSION['orden']['zipcode'])) { header("location: index.php"); }

$menu[0] = '';
$menu[2] = 'class="active"';
$navegacion[2] = 'class="active"';

if(isset($_GET['cat'])) { $id_categoria = $_GET['cat']; } else { $id_categoria = 0; }

// Listar Productos
$listado_productos = $producto->listado(2, $id_categoria, 0, -1, 1);
$total_productos = $producto->total_listado(2, $id_categoria, 0, -1, 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Drinks :: Delivery Troop</title>
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
			<?php if(($id_categoria == 0) || ($id_categoria == 27)) { ?>
			<div class="row">
				<div class="col-xs-12">
					<img src="img/warning21.jpg" alt="Warning Alcohol" title="Warning Alcohol" class="img-responsive center-block" />
				</div>
			</div>
			<hr class="separador2" />
			<?php } ?>
			<div class="row">
				<div class="col-xs-12 col-md-8">
					<h1>Drinks</h1>
				</div>
				<div class="col-xs-12 col-md-4">
					<div>&nbsp;</div>
					<select name="categoria" class="form-control menu_select" data-url="drinks.php?cat">
						<option value="0">Select Category</option>
            <?php // Listar Categorias
                  $listado_categorias = $categoria->listado(2, 1);
                  $total_categorias = $categoria->total_listado(2, 1);

                  if($total_categorias > 0) {
                    foreach($listado_categorias as $reg_categoria) { ?>
            <option value="<?=$reg_categoria->obtener_id()?>" <?php if($reg_categoria->obtener_id() == $id_categoria) { echo 'selected'; } ?>><?=$reg_categoria->nombre?></option>
            <?php   }
                  } ?>
          </select>
				</div>
			</div>
			<hr class="separador2" />
			<?php if($total_productos > 0) { ?>
			<div class="row">
				<?php foreach($listado_productos as $reg_producto) {
								$id_producto = $reg_producto->obtener_id();

								if($reg_producto->imagen != '') { $producto_img = "archivos_productos/".$reg_producto->imagen; }
								else { $producto_img = "img/no_img.jpg"; }

								$precio = $presentacion->precio_minimo($id_producto); ?>
				<div class="col-sm-6 col-md-3">
					<article class="producto-grilla">
						<div class="imagen">
							<img src="<?=$producto_img?>" alt="<?=$reg_producto->nombre?>" title="<?=$reg_producto->nombre?>" class="img-responsive center-block" />
							<button type="button" class="boton_foto" name="ordenar" data-id="<?=$id_producto?>">Order Now</button>
						</div>
						<div class="info">
							<div class="titulo"><?=$reg_producto->nombre?></div>
							<div class="precio">$<?=number_format($precio, 2)?></div>
							<div class="resumen">
								<?=$reg_producto->resumen?><br />
								<a href="#" data-id="<?=$id_producto?>" class="food-details">More Details</a>
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

	<div id="warning" class="modal fade" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title">Terms of use</h4>
	      </div>
	      <div class="modal-body">
	        <p>A person at least twenty one (21) years of age must be available and able to provide valid photo identification at the time of accepting delivery of any alcoholic beverages.</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-success" data-dismiss="modal">Agree</button>
	        <button type="button" class="btn btn-danger" id="disagree">Disagree</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div id="ProductoDetalles" class="modal fade" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">#PRODUCTO-NOMBRE#</h4>
	      </div>
	      <div class="modal-body">
	        <div class="row">
	        	<div class="col-xs-12 col-sm-6 col-sm-offset-3 prod-img">#PRODUCTO-IMG#</div>
	        </div>
	        <div class="row">
	        	<div class="col-xs-12 prod-desc">#PRODUCTO-DESCRIPCION#</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div id="ProductoOrdenar" class="modal fade" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <form id="form_ordenar" class="form_ordenar" method="post">
	      	<input type="hidden" name="producto" value="0" />
	      	<input type="hidden" name="precio" value="---" />
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">#PRODUCTO-NOMBRE#</h4>
		      </div>
		      <div class="modal-body">
	        	<div id="error" class="alert alert-danger hidden" role="alert">
		          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		          <i class="fa fa-times"></i> <span id="msjError">Error</span>
		        </div>
	        	<div class="form-group">
							<label for="opcion1" class="control-label">Option 1:</label>
							<select name="opcion1" class="form-control">
								<option value="0">Select</option>
							</select>
						</div>
						<div class="form-group">
							<label for="opcion2" class="control-label">Option 2:</label>
							<select name="opcion2" class="form-control">
								<option value="0">Select</option>
							</select>
						</div>
						<div class="precio">Price: $<span id="precio">---</span></div>
	        	<div class="form-group">
							<label for="cantidad" class="control-label">Quantity:</label>
							<input type="text" class="form-control" name="cantidad" placeholder="Quantity" aria-describedby="bloqueErrorCantidad" />
							<span class="help-block" id="bloqueErrorCantidad"></span>
						</div>
						<div class="form-group">
							<label for="instrucciones" class="control-label">Special Instructions:</label>
							<textarea name="instrucciones" cols="30" rows="4" class="form-control" placeholder="Special Instructions"></textarea>
						</div>
		      </div>
		      <div class="modal-footer">
		      	<button type="submit" class="btn btn-success">Add to Cart</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.min.js"></script>
  <!-- Custom -->
  <script src="js/deliverytroop.js"></script>
  <?php if(($id_categoria == 0) || ($id_categoria == 27)) { ?>
  <script>
  $('#warning').modal('show');
  $('#disagree').click(function() {
  	$('#warning').modal('hide');
  	location.href = 'index.php';
  });
  </script>
  <?php } ?>
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