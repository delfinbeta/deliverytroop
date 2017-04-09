<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");

// Clases
require("../../clases/clase_contenido.php");

// Objetos
$contenido = new Contenido($conexion);

if(isset($_GET['id'])) { $id_contenido = $_GET['id']; } else { $id_contenido = 0; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Contents :: Delivery Troop</title>
	<meta name="description" content="Delivery Troop, On Demand Delivery Service" />
	<meta name="creator" content="www.delfinbeta.com.ve" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- Bootstrap -->
	<link rel="stylesheet" href="../../css/bootstrap.min.css" />
	<!-- Font-Awesome-4.7.0 -->
	<link rel="stylesheet" href="../../font-awesome-4.7.0/css/font-awesome.min.css" />
	<!-- Bootstrap Wysihtml5 -->
	<link rel="stylesheet" href="../../bootstrap3-wysiwyg-master/dist/bootstrap3-wysihtml5.min.css" />
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
				<h1>Content</h1>
				<ol class="breadcrumb">
				  <li><a href="index.php">Contents</a></li>
				  <li class="active">Content</li>
				</ol>
				<?php if($contenido->datos($id_contenido)) { ?>
				<div class="panel panel-default">
					<div class="panel-heading">Edit:</div>
					<div class="panel-body">
						<form id="form_modificar" name="form_modificar" method="post" enctype="multipart/form-data">
          		<div id="error" class="alert alert-danger hidden" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <i class="fa fa-times"></i> <span id="msjError">Error</span>
              </div>
              <input type="hidden" name="id" value="<?=$id_contenido?>" />
              <div class="row">
              	<div class="col-xs-12 form-group has-feedback">
            			<label for="nombre">Name:</label>
            			<div class="input-group">
            				<div class="input-group-addon"><i class="fa fa-user"></i></div>
            				<input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?=$contenido->nombre?>" aria-describedby="bloqueErrorNombre"  />
            			</div>
            			<span id="bloqueErrorNombre" class="help-block"></span>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-xs-12 form-group has-feedback">
            			<label for="descripcion" class="sr-only">Text:</label>
            			<textarea name="descripcion" class="form-control textarea" cols="30" rows="10" placeholder="Enter text ..." aria-describedby="bloqueErrorDescripcion"><?=$contenido->descripcion?></textarea>
            			<span id="bloqueErrorDescripcion" class="help-block"></span>
            		</div>
              </div>
          		<div class="row text-center">
        				<button type="submit" class="btn btn-primary">Save</button>
          		</div>
          	</form>
					</div>
				</div>
				<?php } else { ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <i class="fa fa-times"></i> Error: <?=$contenido->error?>
        </div>
        <?php } ?>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../../js/bootstrap.min.js"></script>
  <!-- Bootstrap Wysihtml5 -->
  <script src="../../bootstrap3-wysiwyg-master/dist/wysihtml5x-toolbar.min.js"></script>
	<script src="../../bootstrap3-wysiwyg-master/dist/handlebars.runtime.min.js"></script>
	<script src="../../bootstrap3-wysiwyg-master/dist/bootstrap3-wysihtml5.min.js"></script>
  <!-- Custom -->
  <script src="../../js/admin.js"></script>
  <script src="../../js/admin_contents.js"></script>
  <script>
  	$('.textarea').wysihtml5();
  </script>
</body>
</html>