<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");

// Clases
require("../../clases/clase_restaurante.php");
require("../../clases/clase_categoria.php");

// Objetos
$restaurante = new Restaurante($conexion);
$categoria = new Categoria($conexion);

if(isset($_GET['id'])) { $id_restaurante = $_GET['id']; } else { $id_restaurante = 0; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Restaurants :: Delivery Troop</title>
	<meta name="description" content="Delivery Troop, On Demand Delivery Service" />
	<meta name="creator" content="www.delfinbeta.com.ve" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- Bootstrap -->
	<link rel="stylesheet" href="../../css/bootstrap.min.css" />
	<!-- Font-Awesome-4.7.0 -->
	<link rel="stylesheet" href="../../font-awesome-4.7.0/css/font-awesome.min.css" />
	<!-- TimePicker -->
  <link rel="stylesheet" media="all" type="text/css" href="../../jQuery-Timepicker-Addon-master/src/jquery-ui-timepicker-addon.css" />
  <link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
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
				<h1>Restaurant</h1>
				<ol class="breadcrumb">
				  <li><a href="index.php">Restaurants</a></li>
				  <li class="active">Restaurant</li>
				</ol>
				<?php if($restaurante->datos($id_restaurante)) {
								if($restaurante->imagen == '') { $ruta_img = $GLOBALS['domain_root']."/img/no_img.jpg"; }
								else { $ruta_img = $GLOBALS['domain_root']."/archivos_restaurantes/".$restaurante->imagen; }

								$id_categoria = $restaurante->obtener_categoria(); ?>
				<div class="panel panel-default">
					<div class="panel-heading">Edit:</div>
					<div class="panel-body">
						<div class="col-md-3">
							<img src="<?=$ruta_img?>" alt="<?=$restaurante->nombre?>" title="<?=$restaurante->nombre?>" class="img-responsive" />
						</div>
						<div class="col-md-9">
							<form id="form_modificar" name="form_modificar" method="post" enctype="multipart/form-data">
	          		<div id="error" class="alert alert-danger hidden" role="alert">
	                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	                <i class="fa fa-times"></i> <span id="msjError">Error</span>
	              </div>
	              <input type="hidden" name="id" value="<?=$id_restaurante?>" />
	              <div class="row">
	              	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	            			<label for="categoria">Category:</label>
	            			<select name="categoria" class="form-control">
	                    <?php // Listar Categorias
	                          $listado_categorias = $categoria->listado(1, 1);
	                          $total_categorias = $categoria->total_listado(1, 1);

	                          if($total_categorias > 0) {
	                            foreach($listado_categorias as $reg_categoria) { ?>
	                    <option value="<?=$reg_categoria->obtener_id()?>" <?php if($reg_categoria->obtener_id() == $id_categoria) { echo 'selected'; } ?>><?=$reg_categoria->nombre?></option>
	                    <?php   }
	                          } ?>
	                  </select>
	            		</div>
	            		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	            			<label for="nombre">Name:</label>
	            			<div class="input-group">
	            				<input type="text" class="form-control" name="nombre" placeholder="Name" value="<?=$restaurante->nombre?>" aria-describedby="bloqueErrorNombre"  />
	            				<div class="input-group-addon"><i class="fa fa-tags"></i></div>
	            			</div>
	            			<span id="bloqueErrorNombre" class="help-block"></span>
	            		</div>
	              </div>
	              <div class="row">
	              	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	              		<label for="zipcode">Zipcode:</label>
	            			<div class="input-group">
	            				<div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
	            				<input type="text" class="form-control" name="zipcode" placeholder="Zipcode" value="<?=$restaurante->zipcode?>" aria-describedby="bloqueErrorZipcode"  />
	            			</div>
	            			<span id="bloqueErrorZipcode" class="help-block"></span>
	              	</div>
	          			<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	            			<label for="direccion">Address:</label>
	            			<div class="input-group">
	            				<input type="text" class="form-control" name="direccion" placeholder="Address" value="<?=$restaurante->direccion?>" aria-describedby="bloqueErrorDireccion"  />
	            				<div class="input-group-addon"><i class="fa fa-building"></i></div>
	            			</div>
	            			<span id="bloqueErrorDireccion" class="help-block"></span>
	            		</div>
	          		</div>
	              <div class="row">
	              	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	            			<label for="hora_inicio">Start time:</label>
	            			<div class="input-group">
	            				<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
	            				<input type="text" class="form-control" name="hora_inicio" id="hora_inicio" value="<?=date("h:i a", strtotime($restaurante->hora_inicio))?>" placeholder="Start time" aria-describedby="bloqueErrorHoraInicio"  />
	            			</div>
	            			<span id="bloqueErrorHoraInicio" class="help-block"></span>
	            		</div>
	            		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	            			<label for="hora_fin">End time:</label>
	            			<div class="input-group">
	            				<input type="text" class="form-control" name="hora_fin" id="hora_fin" value="<?=date("h:i a", strtotime($restaurante->hora_fin))?>" placeholder="End time" aria-describedby="bloqueErrorHoraFin"  />
	            				<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
	            			</div>
	            			<span id="bloqueErrorHoraFin" class="help-block"></span>
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
          <i class="fa fa-times"></i> Error: <?=$restaurante->error?>
        </div>
        <?php } ?>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../../js/bootstrap.min.js"></script>
  <!-- TimePicker -->
  <script type="text/javascript" language="javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
  <script type="text/javascript" language="javascript" src="../../jQuery-Timepicker-Addon-master/src/jquery-ui-timepicker-addon.js"></script>
  <!-- Custom -->
  <script src="../../js/admin.js"></script>
  <script src="../../js/admin_restaurants.js"></script>
  <script>
	  $(function() {
	    var campo_inicio = $('#hora_inicio');
	    var campo_fin = $('#hora_fin');

	    $.timepicker.timeRange(
	      campo_inicio,
	      campo_fin,
	      {
	        minInterval: (1000*60*60), // 1hr
	        timeFormat: 'hh:mm tt',
	        controlType: 'select',
	        oneLine: true,
	        start: {}, /* start picker options */
	        end: {} /* end picker options */
	      }
	    );
	  });
  </script>
</body>
</html>