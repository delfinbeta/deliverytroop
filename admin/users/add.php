<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");
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
				<h1>Add User</h1>
				<ol class="breadcrumb">
				  <li><a href="index.php">Users</a></li>
				  <li class="active">Add User</li>
				</ol>
				<div class="panel panel-default">
				  <div class="panel-heading">Add User</div>
				  <div class="panel-body">
				  	<form id="form_insertar" name="form_insertar" method="post" enctype="multipart/form-data">
          		<div id="error" class="alert alert-danger hidden" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <i class="fa fa-times"></i> <span id="msjError">Error</span>
              </div>
              <div class="row">
              	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
            			<label for="usuario" class="sr-only">Username:</label>
            			<div class="input-group">
            				<div class="input-group-addon"><i class="fa fa-user"></i></div>
            				<input type="text" class="form-control" name="usuario" placeholder="Username" aria-describedby="bloqueErrorUsuario"  />
            			</div>
            			<span id="bloqueErrorUsuario" class="help-block"></span>
            		</div>
            		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
            			<label for="contrasena" class="sr-only">Password:</label>
            			<div class="input-group">
            				<input type="password" class="form-control" name="contrasena" placeholder="Password" aria-describedby="bloqueErrorContrasena"  />
            				<div class="input-group-addon"><i class="fa fa-lock"></i></div>
            			</div>
            			<span id="bloqueErrorContrasena" class="help-block"></span>
            		</div>
              </div>
              <div class="row">
              	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
            			<label for="nombre" class="sr-only">Name:</label>
            			<div class="input-group">
            				<div class="input-group-addon"><i class="fa fa-user"></i></div>
            				<input type="text" class="form-control" name="nombre" placeholder="Name" aria-describedby="bloqueErrorNombre"  />
            			</div>
            			<span id="bloqueErrorNombre" class="help-block"></span>
            		</div>
            		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
            			<label for="apellido" class="sr-only">Last name:</label>
            			<div class="input-group">
            				<input type="text" class="form-control" name="apellido" placeholder="Last name" aria-describedby="bloqueErrorApellido"  />
            				<div class="input-group-addon"><i class="fa fa-user"></i></div>
            			</div>
            			<span id="bloqueErrorApellido" class="help-block"></span>
            		</div>
              </div>
          		<div class="row">
          			<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
            			<label for="email" class="sr-only">Email:</label>
            			<div class="input-group">
            				<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
            				<input type="email" class="form-control" name="email" placeholder="Email" aria-describedby="bloqueErrorEmail"  />
            			</div>
            			<span id="bloqueErrorEmail" class="help-block"></span>
            		</div>
            		<div class="col-md-6 col-sm-6 col-xs-12 form-group">
            			<div class="radio-inline">
            				<label><input type="radio" name="sexo" value="1" required /> Female</label>
            			</div>
            			<div class="radio-inline">
            				<label><input type="radio" name="sexo" value="2" /> Male</label>
            			</div>
            			<div class="radio-inline">
            				<label><input type="radio" name="sexo" value="3" checked /> Other</label>
            			</div>
            		</div>
          		</div>
          		<div class="row">
          			<div class="col-xs-12 form-group has-feedback">
            			<label for="foto" class="sr-only">Picture:</label>
            			<div class="input-group">
            				<div class="input-group-addon"><i class="fa fa-camera"></i></div>
            				<input type="file" class="form-control" name="foto" placeholder="Picture" />
            			</div>
            		</div>
          		</div>
          		<div class="row text-center">
        				<button type="submit" class="btn btn-primary">Add User</button>
          		</div>
          	</form>
				  </div>
				</div>
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