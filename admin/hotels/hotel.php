<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");

// Clases
require("../../clases/clase_hotel.php");

// Objetos
$hotel = new Hotel($conexion);

if(isset($_GET['id'])) { $id_hotel = $_GET['id']; } else { $id_hotel = 0; }
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
	<link rel="stylesheet" href="../../css/bootstrap.min.css" />
	<!-- Font-Awesome-4.7.0 -->
	<link rel="stylesheet" href="../../font-awesome-4.7.0/css/font-awesome.min.css" />
  <!-- Custom -->
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
				<h1>Hotel</h1>
				<ol class="breadcrumb">
				  <li><a href="index.php">Hotels</a></li>
				  <li class="active">Hotel</li>
				</ol>
				<?php if($hotel->datos($id_hotel)) {
								if($hotel->imagen == '') { $ruta_img = $GLOBALS['domain_root']."/img/no_img.jpg"; }
								else { $ruta_img = $GLOBALS['domain_root']."/archivos_hoteles/".$hotel->imagen; } ?>
				<div class="panel panel-default">
					<div class="panel-heading">Edit:</div>
					<div class="panel-body">
						<div class="col-md-3">
							<img src="<?=$ruta_img?>" alt="<?=$hotel->nombre?>" title="<?=$hotel->nombre?>" class="img-responsive" />
						</div>
						<div class="col-md-9">
							<form id="form_modificar" name="form_modificar" method="post" enctype="multipart/form-data">
	          		<div id="error" class="alert alert-danger hidden" role="alert">
	                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	                <i class="fa fa-times"></i> <span id="msjError">Error</span>
	              </div>
	              <input type="hidden" name="id" value="<?=$id_hotel?>" />
	              <div class="row">
	              	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	            			<label for="nombre">Name:</label>
	            			<div class="input-group">
	            				<div class="input-group-addon"><i class="fa fa-tags"></i></div>
	            				<input type="text" class="form-control" name="nombre" placeholder="Name" value="<?=$hotel->nombre?>" aria-describedby="bloqueErrorNombre"  />
	            			</div>
	            			<span id="bloqueErrorNombre" class="help-block"></span>
	            		</div>
	            		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	            			<label for="zipcode">Zipcode:</label>
	            			<div class="input-group">
	            				<input type="text" class="form-control" name="zipcode" placeholder="Zipcode" value="<?=$hotel->zipcode?>" aria-describedby="bloqueErrorZipcode"  />
	            				<div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
	            			</div>
	            			<span id="bloqueErrorZipcode" class="help-block"></span>
	            		</div>
	              </div>
	              <div class="row">
	              	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	              		<label for="ciudad">City:</label>
	            			<div class="input-group">
	            				<div class="input-group-addon"><i class="fa fa-globe"></i></div>
	            				<input type="text" class="form-control" name="ciudad" placeholder="City" value="<?=$hotel->ciudad?>" aria-describedby="bloqueErrorCiudad"  />
	            			</div>
	            			<span id="bloqueErrorCiudad" class="help-block"></span>
	              	</div>
	          			<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	            			<label for="direccion">Address:</label>
	            			<div class="input-group">
	            				<input type="text" class="form-control" name="direccion" placeholder="Address" value="<?=$hotel->direccion?>" aria-describedby="bloqueErrorDireccion"  />
	            				<div class="input-group-addon"><i class="fa fa-building"></i></div>
	            			</div>
	            			<span id="bloqueErrorDireccion" class="help-block"></span>
	            		</div>
	          		</div>
	          		<div class="row">
	          			<div class="col-xs-12 form-group has-feedback">
	            			<label for="imagen">Picture:</label>
	            			<div class="input-group">
	            				<div class="input-group-addon"><i class="fa fa-camera"></i></div>
	            				<input type="file" class="form-control" name="imagen" placeholder="Picture" />
	            			</div>
	            		</div>
	          		</div>
	          		<div class="row text-center">
	        				<button type="submit" class="btn btn-primary">Save</button>
	          		</div>
	          	</form>
						</div>
					</div>
				</div>
				<?php } else { ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <i class="fa fa-times"></i> Error: <?=$hotel->error?>
        </div>
        <?php } ?>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../../js/bootstrap.min.js"></script>
  <!-- Custom -->
  <script src="../../js/admin.js"></script>
  <script src="../../js/admin_hotels.js"></script>
</body>
</html>