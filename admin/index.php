<?php
require("../configuracion/inicio_admin.php");
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
	<div class="container-fluid login">
		<section class="login-wrapper">
      <form id="form_login" name="form_login" action="login.php" method="post" role="form">
        <div><img src="../img/deliverytroop.png" alt="Delivery Troop" title="Delivery Troop" class="img-responsive" /></div>
        <h2>Admin</h2>
				<div id="login-error" class="alert alert-danger hidden" role="alert">Danger</div>
        <div class="form-group">
          <label for="usuario" class="sr-only">User:</label>
          <input type="text" name="usuario" class="form-control" placeholder="User"  aria-describedby="bloqueErrorUsuario" />
          <span id="bloqueErrorUsuario" class="help-block"></span>
        </div>
        <div class="form-group">
          <label for="contrasena" class="sr-only">Password:</label>
          <input type="password" name="contrasena" class="form-control" placeholder="Password"  aria-describedby="bloqueErrorContrasena" />
          <span id="bloqueErrorContrasena" class="help-block"></span>
        </div>
        <button type="submit" class="btn btn-default boton-amarillo submit">Login</button>

        <hr />

        <p><a href="#">Forget your password?</a></p>
        <p>©2016 All Rights Reserved. Delivery Troop.</p>
      </form>
    </section>
	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/admin.js"></script>
  <script>
  	$("#form_login").submit(function(ev) {
			ev.preventDefault();

			var enviar = true;
			var $campoUsuario = $(this).find('input[name="usuario"]');
			var $campoContrasena = $(this).find('input[name="contrasena"]');

			var usuario = $campoUsuario.val();
			var contrasena = $campoContrasena.val();

			$(".form-group").removeClass('has-error');
			$(".help-block").html("");
			$("#login_error").addClass('hidden');

			if(usuario == '') {
				$campoUsuario.parents('.form-group').addClass('has-error');
				$("#bloqueErrorUsuario").html("User is required");
				enviar = false;
			}

			if(contrasena == '') {
				$campoContrasena.parents('.form-group').addClass('has-error');
				$("#bloqueErrorContrasena").html("Password is required");
				enviar = false;
			}

			if(enviar) {
				$.post("../ajax/admin/login.php", { usuario: usuario, contrasena: contrasena }, function(data) {
					console.log("Error: " + data.error);
					console.log("Mensaje: " + data.mensaje);

					if(data.error) {
						$("#login-error").removeClass('hidden').html(data.mensaje);
					} else {
						location.href = "inicio.php";
					}
				}, "json");
			}
		});
  </script>
</body>
</html>