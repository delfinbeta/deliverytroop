<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");

// Clases
require("../../clases/clase_usuario.php");

// Objetos
$usuario = new Usuario($conexion);

if(isset($_GET['id'])) { $id_usuario = $_GET['id']; } else { $id_usuario = 0; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Users :: Delivery Troop</title>
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
				<h1>User</h1>
				<ol class="breadcrumb">
				  <li><a href="index.php">Users</a></li>
				  <li class="active">User</li>
				</ol>
				<?php if($usuario->datos($id_usuario)) {
      					if($usuario->foto == '') {
                  if($usuario->obtener_codSexo() == 1) { $ruta_img = $GLOBALS['domain_root']."/img/usuario_mujer.jpg"; }
                  else { $ruta_img = $GLOBALS['domain_root']."/img/usuario_hombre.jpg"; }
                } else {
                  $ruta_img = $GLOBALS['domain_root']."/archivos_usuarios/".$usuario->foto;
                }

                $marca = array('', '', '');
                $pos = $usuario->obtener_codSexo() - 1;
                $marca[$pos] = 'checked'; ?>
				<div class="col-md-3">
					<div class="panel panel-default">
					  <div class="panel-heading">User:</div>
					  <div class="panel-body">
				    	<img src="<?=$ruta_img?>" alt="<?=$usuario->nombre.' '.$usuario->apellido?>" title="<?=$usuario->nombre.' '.$usuario->apellido?>" class="img-responsive" />
				    	<h3><?=$usuario->nombre?> <?=$usuario->apellido?></h3>
				    	<ul class="list-unstyled">
                <li><i class="fa fa-fw fa-user"></i> <strong>user:</strong> <?=$usuario->obtener_usuario()?></li>
                <li><i class="fa fa-fw fa-envelope"></i> <strong>email:</strong> <?=$usuario->email?></li>
                <?php if($usuario->obtener_codSexo() == 1) { $icono_sexo = "fa-female"; } else { $icono_sexo = "fa-male"; } ?>
                <li><i class="fa fa-fw <?=$icono_sexo?>"></i> <strong>gender:</strong> <?=$usuario->obtener_sexo()?></li>
                <li><i class="fa fa-fw fa-wrench"></i> <strong>type:</strong> <?=$usuario->obtener_tipo()?></li>
              </ul>
					  </div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-heading">Edit:</div>
						<div class="panel-body">
							<form id="form_modificar" name="form_modificar" method="post" enctype="multipart/form-data">
            		<div id="error" class="alert alert-danger hidden" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <i class="fa fa-times"></i> <span id="msjError">Error</span>
                </div>
                <input type="hidden" name="id" value="<?=$id_usuario?>" />
                <div class="row">
                	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
              			<label for="nombre">Name:</label>
              			<div class="input-group">
              				<div class="input-group-addon"><i class="fa fa-user"></i></div>
              				<input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?=$usuario->nombre?>" aria-describedby="bloqueErrorNombre"  />
              			</div>
              			<span id="bloqueErrorNombre" class="help-block"></span>
              		</div>
              		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
              			<label for="apellido">Last name:</label>
              			<div class="input-group">
              				<input type="text" class="form-control" name="apellido" placeholder="Apellido" value="<?=$usuario->apellido?>" aria-describedby="bloqueErrorApellido"  />
              				<div class="input-group-addon"><i class="fa fa-user"></i></div>
              			</div>
              			<span id="bloqueErrorApellido" class="help-block"></span>
              		</div>
                </div>
            		<div class="row">
            			<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
              			<label for="email">Email:</label>
              			<div class="input-group">
              				<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
              				<input type="email" class="form-control" name="email" placeholder="Email" value="<?=$usuario->email?>" aria-describedby="bloqueErrorEmail"  />
              			</div>
              			<span id="bloqueErrorEmail" class="help-block"></span>
              		</div>
              		<div class="col-md-6 col-sm-6 col-xs-12 form-group">
              			<p>&nbsp;</p>
              			<div class="radio-inline">
              				<label><input type="radio" name="sexo" value="1" <?=$marca[0]?> required /> Female</label>
              			</div>
              			<div class="radio-inline">
              				<label><input type="radio" name="sexo" value="2" <?=$marca[1]?> /> Male</label>
              			</div>
              			<div class="radio-inline">
              				<label><input type="radio" name="sexo" value="3" <?=$marca[2]?> /> Other</label>
              			</div>
              		</div>
            		</div>
            		<div class="row">
            			<div class="col-xs-12 form-group has-feedback">
              			<label for="foto">Picture:</label>
              			<div class="input-group">
              				<div class="input-group-addon"><i class="fa fa-camera"></i></div>
              				<input type="file" class="form-control" name="foto" placeholder="Foto" />
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
          <i class="fa fa-times"></i> Error: <?=$usuario->error?>
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
  <script src="../../js/admin_users.js"></script>
</body>
</html>