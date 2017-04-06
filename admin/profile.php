<?php
require("../configuracion/inicio_admin.php");
require("sesion.php");

$marca = array('', '', '');
$pos = $_SESSION['usuario_sexo'] - 1;
$marca[$pos] = 'checked';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Admin :: Delivery Troop</title>
	<meta name="description" content="Delivery Troop, On Demand Delivery Service" />
	<meta name="creator" content="www.delfinbeta.com.ve" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- Bootstrap -->
	<link rel="stylesheet" href="../css/bootstrap.min.css" />
	<!-- Font-Awesome-4.7.0 -->
	<link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="../css/admin.css" />
	<link rel="shortcut icon" href="../img/favicon/favicon.ico" />
</head>
<body>
	<div class="container-fluid">
		<div class="row row-offcanvas row-offcanvas-left">
			<?php require("../plantillas/menu_admin.php"); ?>
			<div class="col-sm-9 col-md-10 main">
				<div class="visible-xs">
					<button type="button" class="btn btn-warning btn-xs" data-toggle="offcanvas"><i class="fa fa-bars"></i> Menu</button>
				</div>
				<h1>Profile</h1>
				<div class="col-md-3">
					<div class="panel panel-default">
					  <div class="panel-heading">Profile:</div>
					  <div class="panel-body">
				    	<img src="<?=$_SESSION['usuario_rutafoto']?>" alt="<?=$_SESSION['usuario_nombre'].' '.$_SESSION['usuario_apellido']?>" title="<?=$_SESSION['usuario_nombre'].' '.$_SESSION['usuario_apellido']?>" class="img-responsive" />
				    	<h3><?=$_SESSION['usuario_nombre']?> <?=$_SESSION['usuario_apellido']?></h3>
				    	<ul class="list-unstyled">
                <li><i class="fa fa-fw fa-user"></i> <strong>user:</strong> <?=$_SESSION['usuario_usuario']?></li>
                <li><i class="fa fa-fw fa-envelope"></i> <strong>email:</strong> <?=$_SESSION['usuario_email']?></li>
                <?php if($_SESSION['usuario_sexo'] == 1) { $icono_sexo = "fa-female"; } else { $icono_sexo = "fa-male"; } ?>
                <li><i class="fa fa-fw <?=$icono_sexo?>"></i> <strong>gender:</strong> <?=$_SESSION['usuario_csexo']?></li>
                <li><i class="fa fa-fw fa-wrench"></i> <strong>type:</strong> <?=$_SESSION['usuario_ctipo']?></li>
              </ul>
					  </div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-heading">Edit:</div>
						<div class="panel-body">
							<form id="form_perfil" name="form_perfil" action="profile.php" method="post" enctype="multipart/form-data">
            		<div id="perfil_exito" class="alert alert-success hidden" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <i class="fa fa-check"></i> Updated profile
                </div>
                <div id="perfil_error" class="alert alert-danger hidden" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <i class="fa fa-times"></i> <span id="msjError">Error</span>
                </div>
                <div class="row">
                	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
              			<label for="nombre">Name:</label>
              			<div class="input-group">
              				<div class="input-group-addon"><i class="fa fa-user"></i></div>
              				<input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?=$_SESSION['usuario_nombre']?>" aria-describedby="bloqueErrorNombre"  />
              			</div>
              			<span id="bloqueErrorNombre" class="help-block"></span>
              		</div>
              		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
              			<label for="apellido">Last name:</label>
              			<div class="input-group">
              				<input type="text" class="form-control" name="apellido" placeholder="Apellido" value="<?=$_SESSION['usuario_apellido']?>" aria-describedby="bloqueErrorApellido"  />
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
              				<input type="email" class="form-control" name="email" placeholder="Email" value="<?=$_SESSION['usuario_email']?>" aria-describedby="bloqueErrorEmail"  />
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
              				<input type="file" class="form-control has-feedback-left" name="foto" placeholder="Foto" />
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
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/admin.js"></script>
  <script>
    $("#form_perfil").submit(function(ev) {
      ev.preventDefault();

      var enviar = true;
      var $campoNombre = $(this).find('input[name="nombre"]');
      var $campoApellido = $(this).find('input[name="apellido"]');
      var $campoEmail = $(this).find('input[name="email"]');

      var nombre = $campoNombre.val();
      var apellido = $campoApellido.val();
      var email = $campoEmail.val();

      $(".form-group").removeClass('has-error');
      $(".help-block").html("");
      $("#perfil_exito").addClass('hidden');
      $("#perfil_error").addClass('hidden');

      if(nombre == '') {
        $campoNombre.parents('.form-group').addClass('has-error');
        $("#bloqueErrorNombre").html("Name is required");
        enviar = false;
      }

      if(apellido == '') {
        $campoApellido.parents('.form-group').addClass('has-error');
        $("#bloqueErrorApellido").html("Last name is required");
        enviar = false;
      }

      if(email == '') {
        $campoEmail.parents('.form-group').addClass('has-error');
        $("#bloqueErrorEmail").html("Email is required");
        enviar = false;
      }

      if(enviar) {
        var formData = new FormData(this);  // Creamos los datos a enviar con el formulario

        $.ajax({
          url: "../ajax/admin/profile.php",    // URL destino
          type: "POST",
          data: formData,               // Datos del Formulario
          dataType: "JSON",
          processData: false,           // Evitamos que JQuery procese los datos, daría error
          contentType: false,           // No especificamos ningún tipo de dato
          cache: false
        }).done(function(data) {
          console.log("Error: " + data.error);
          console.log("Mensaje: " + data.mensaje);

          if(data.error) {
            $("#perfil_error").removeClass('hidden');
            $("#msjError").html(data.mensaje);
          } else {
            $("#crop-avatar").html(data.foto);
            $("#perfil_exito").removeClass('hidden');
          }
        }).fail(function() {
          $('#perfil_error').removeClass('hidden');
          $('#msjError').html("Ha ocurrido un error. Contacte a Sistemas.");
        });
      }
    });
  </script>
</body>
</html>