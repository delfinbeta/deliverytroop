<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");

// Clases
require("../../clases/clase_orden.php");
require("../../clases/clase_general.php");

// Objetos
$orden = new Orden($conexion);
$general = new General($conexion);

// Listar Ordenes
$listado = $orden->listado('', '', -1, -1);
$total = $orden->total_listado('', '', -1, -1);
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
				<h1>Orders</h1>
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<div class="pull-left">Orders list</div>
				  	<div class="clearfix"></div>
				  </div>
				  <div class="panel-body">
				  	<?php if(isset($_GET['m'])) { ?>
          	<div id="exito" class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              <i class="fa fa-check"></i>
              <?php if($_GET['m'] == "I") { echo "Order added"; }
              			if($_GET['m'] == "M") { echo "Order edited"; }
              			if($_GET['m'] == "E") { echo "Order deleted"; } ?>
            </div>
            <?php } ?>
            <div id="error" class="alert alert-danger hidden" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              <i class="fa fa-times"></i> <span id="msjError">Error</span>
            </div>
				    <table id="tabla" class="table table-striped table-bordered" cellspacing="0" width="100%">
					    <thead>
				        <tr>
                  <th>Date</th>
                  <th>Code</th>
                  <th>Customer</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th width="100">&nbsp;</th>
                  <th width="26">&nbsp;</th>
                  <th width="26">&nbsp;</th>
                </tr>
					    </thead>
					    <?php if($total > 0) { ?>
					    <tbody>
					    	<?php foreach($listado as $registro) { ?>
	              <tr>
	              	<td><?=$general->muestrafecha($registro->obtener_fecha_registro())?></td>
	                <td><a href="order.php?id=<?=$registro->obtener_id()?>"><?=str_pad($registro->obtener_id(), 5, "0", STR_PAD_LEFT);?></a></td>
	                <td><a href="order.php?id=<?=$registro->obtener_id()?>"><?=$registro->nombre?></a></td>
	                <td align="right">$<?=$registro->total?></td>
	                <td><?=$registro->obtener_estado()?></td>
	                <td>
	                	<?php if($registro->obtener_codEstado() == 1) { ?>
	                	<button type="button" class="btn btn-info estatus" data-reg="<?=$registro->obtener_id()?>" data-estado="2"><i class="fa fa-usd"></i> Paid out</button>
	                	<?php } ?>
	                	<?php if($registro->obtener_codEstado() == 2) { ?>
	                	<button type="button" class="btn btn-danger estatus" data-reg="<?=$registro->obtener_id()?>" data-estado="3"><i class="fa fa-usd"></i> Payment Reject</button>
	                	<?php } ?>
	                	<?php if($registro->obtener_codEstado() == 2) { ?>
	                	<button type="button" class="btn btn-success estatus" data-reg="<?=$registro->obtener_id()?>" data-estado="4"><i class="fa fa-car"></i> Delivery</button>
	                	<?php } ?>
	                	&nbsp;
	                </td>
	                <td><a href="order.php?id=<?=$registro->obtener_id()?>"><i class="icono fa fa-file-text-o"></i></a></td>
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
  <script src="../../DataTables-master/media/js/moment.min.js"></script>
  <script src="../../DataTables-master/media/js/jquery.dataTables.min.js"></script>
  <script src="../../DataTables-master/media/js/dataTables.bootstrap.min.js"></script>
  <script src="../../DataTables-master/media/js/datetime-moment.js"></script>
  <!-- Custom -->
  <script src="../../js/admin.js"></script>
  <script src="../../js/admin_orders.js"></script>
  <script>
  	$(document).ready(function() {
  		$.fn.dataTable.moment('DD-MM-YYYY');
	    $('#tabla').DataTable({
	    	"scrollX": true,
	      "order": [[ 0, "desc" ]],
	      "columns": [
	        null,
	        null,
	        null,
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