<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");

// Clases
require("../../clases/clase_comentario.php");

// Objetos
$comentario = new Comentario($conexion);

if(isset($_GET['id'])) { $id_comentario = $_GET['id']; } else { $id_comentario = 0; }
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
				<h1>Message</h1>
				<ol class="breadcrumb">
				  <li><a href="index.php">Messages</a></li>
				  <li class="active">Message</li>
				</ol>
				<?php if($comentario->datos($id_comentario)) { ?>
				<div class="panel panel-default">
					<div class="panel-heading">Message:</div>
					<div class="panel-body">
						<form id="form_modificar" name="form_modificar" method="post" enctype="multipart/form-data">
          		<div id="error" class="alert alert-danger hidden" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <i class="fa fa-times"></i> <span id="msjError">Error</span>
              </div>
              <input type="hidden" name="id" value="<?=$id_comentario?>" />
              <div class="row">
              	<div class="col-md-6 col-sm-6 col-xs-12">
            			<label>Name:</label>
            			<?=$comentario->nombre?>
            		</div>
            		<div class="col-md-6 col-sm-6 col-xs-12">
            			<label>Email:</label>
                  <?=$comentario->email?>
            		</div>
              </div>
              <div class="row">
              	<div class="col-xs-12">
              		<label>Message:</label>
              		<?=$comentario->comentario?>
              	</div>
              </div>
              <?php if(($comentario->respondido == 0) && ($comentario->obtener_codEstado() != 0)) { ?>
              <div class="row">
              	<div class="col-xs-12 form-group">
              		<label for="respuesta">Reply:</label>
            			<div class="input-group">
            				<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
            				<textarea name="respuesta" class="form-control" cols="30" rows="10" placeholder="Reply" aria-describedby="bloqueErrorRespuesta"></textarea>
            			</div>
            			<span id="bloqueErrorRespuesta" class="help-block"></span>
              	</div>
              </div>
          		<div class="row text-center">
        				<button type="submit" class="btn btn-primary">Send Message</button>
          		</div>
              <?php } else { ?>
              <div class="row">
              	<div class="col-xs-12">
              		<label>Reply:</label>
              		<?=$comentario->respuesta?>
              	</div>
              </div>
              <?php } ?>
          	</form>
					</div>
				</div>
				<?php } else { ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <i class="fa fa-times"></i> Error: <?=$comentario->error?>
        </div>
        <?php } ?>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/admin.js"></script>
  <script src="../../js/admin_messages.js"></script>
</body>
</html>