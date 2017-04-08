<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");

// Clases
require("../../clases/clase_comentario.php");
require("../../clases/clase_general.php");

// Objetos
$comentario = new Comentario($conexion);
$general = new General($conexion);

// Listar Comentarios
$listado = $comentario->listado(-1);
$total = $comentario->total_listado(-1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Messages :: Delivery Troop</title>
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
				<h1>Messages</h1>
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	Message list
				  	<div class="clearfix"></div>
				  </div>
				  <div class="panel-body">
				  	<?php if(isset($_GET['m'])) { ?>
          	<div id="exito" class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              <i class="fa fa-check"></i>
              <?php if($_GET['m'] == "M") { echo "Message answered"; }
              			if($_GET['m'] == "E") { echo "Message deleted"; } ?>
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
				        	<th>Date</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Reply</th>
                  <th width="26">&nbsp;</th>
                  <th width="26">&nbsp;</th>
                </tr>
					    </thead>
					    <tbody>
					    	<?php foreach($listado as $registro) { ?>
	              <tr>
	              	<td><?=$general->muestrafecha($registro->obtener_fecha_registro())?></td>
	                <td><a href="message.php?id=<?=$registro->obtener_id()?>"><?=$registro->nombre?></a></td>
	                <td><?=$registro->email?></td>
	                <td><?php if($registro->respondido == 1) { echo 'YES'; } else { echo 'NO'; } ?></td>
	                <td><a href="message.php?id=<?=$registro->obtener_id()?>"><i class="icono fa fa-file-text-o"></i></a></td>
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
  <script src="../../js/admin_messages.js"></script>
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
	        { "orderable": false },
	        { "orderable": false }
	      ]
	    });
	  });
  </script>
</body>
</html>