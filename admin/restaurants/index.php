<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");

// Clases
require("../../clases/clase_restaurante.php");

// Objetos
$restaurante = new Restaurante($conexion);

// Listar Restaurantes
$listado = $restaurante->listado('', 1);
$total = $restaurante->total_listado('', 1);
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
	<!-- DataTables -->
	<link rel="stylesheet" href="../../DataTables-master/media/css/dataTables.bootstrap.min.css" />
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
				<h1>Restaurants</h1>
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<div class="pull-left">Restaurant list</div>
				  	<div class="pull-right"><a href="add.php" class="btn btn-success"><i class="fa fa-plus"></i> Add Restaurant</a></div>
				  	<div class="clearfix"></div>
				  </div>
				  <div class="panel-body">
				  	<?php if(isset($_GET['m'])) { ?>
          	<div id="exito" class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              <i class="fa fa-check"></i>
              <?php if($_GET['m'] == "I") { echo "Restaurante added"; }
              			if($_GET['m'] == "M") { echo "Restaurante edited"; }
              			if($_GET['m'] == "E") { echo "Restaurante deleted"; } ?>
            </div>
            <?php } ?>
            <div id="error" class="alert alert-danger hidden" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              <i class="fa fa-times"></i> <span id="msjError">Error</span>
            </div>
				    <table id="tabla" class="table table-striped table-bordered" cellspacing="0" width="100%">
					    <?php if($total > 0) { ?>
					    <thead>
				        <tr>
				        	<th width="100"></th>
                  <th>Restaurante</th>
                  <th width="26">&nbsp;</th>
                  <th width="26">&nbsp;</th>
                  <th width="26">&nbsp;</th>
                </tr>
					    </thead>
					    <tbody>
					    	<?php foreach($listado as $registro) {
					    					if($registro->imagen == '') { $ruta_img = $GLOBALS['domain_root']."/img/no_img.jpg"; }
					    					else { $ruta_img = $GLOBALS['domain_root']."/archivos_restaurantes/".$registro->imagen; } ?>
	              <tr>
	                <td>
	                	<a href="restaurant.php?id=<?=$registro->obtener_id()?>"><img src="<?=$ruta_img?>" width="100" alt="<?=$registro->nombre?>" title="<?=$registro->nombre?>" /></a>
	                </td>
	                <td><a href="restaurant.php?id=<?=$registro->obtener_id()?>"><?=$registro->nombre?></a></td>
	                <td><a href="../food/index.php?id=<?=$registro->obtener_id()?>"><i class="icono fa fa-cutlery"></i></a></td>
	                <td><a href="restaurant.php?id=<?=$registro->obtener_id()?>"><i class="icono fa fa-file-text-o"></i></a></td>
	                <td><a href="#" class="boton-eliminar" data-reg="<?=$registro->obtener_id()?>"><i class="icono fa fa-remove"></i></a></td>
	              </tr>
	              <?php } ?>
					    </tbody>
					    <?php } ?>
					  </table>
				  </div>
				</div>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../../js/bootstrap.min.js"></script>
  <!-- DataTables -->
  <script src="../../DataTables-master/media/js/jquery.dataTables.min.js"></script>
  <script src="../../DataTables-master/media/js/dataTables.bootstrap.min.js"></script>
  <script src="../../js/admin.js"></script>
  <script src="../../js/admin_restaurants.js"></script>
  <script>
  	$(document).ready(function() {
	    $('#tabla').DataTable({
	    	"scrollX": true,
	      "order": [[ 1, "asc" ]],
	      "columns": [
	        null,
	        null,
	        { "orderable": false },
	        { "orderable": false },
	        { "orderable": false }
	      ]
	    });
	  });
  </script>
</body>
</html>