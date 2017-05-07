<?php require("../configuracion/inicio_admin.php"); ?>
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
      <form id="form_password" name="form_password" action="login.php" method="post" role="form">
        <div><img src="../img/deliverytroop.png" alt="Delivery Troop" title="Delivery Troop" class="img-responsive" /></div>
        <h2>Forget your password?</h2>
				<div id="password-error" class="alert alert-danger hidden" role="alert">Danger</div>
        <div class="form-group">
          <label for="email" class="sr-only">Email:</label>
          <input type="email" name="email" class="form-control" placeholder="Email"  aria-describedby="bloqueErrorEmail" />
          <span id="bloqueErrorEmail" class="help-block"></span>
        </div>
        <button type="submit" class="btn btn-default boton-amarillo submit">Send</button>

        <hr />

        <p><a href="index.php">Login</a></p>
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
  	$("#form_password").submit(function(ev) {
			ev.preventDefault();

			var enviar = true;
			var $campoEmail = $(this).find('input[name="email"]');
			var email = $campoEmail.val();

			$(".form-group").removeClass('has-error');
			$(".help-block").html("");
			$("#password-error").addClass('hidden');

			if(email == '') {
				$campoEmail.parents('.form-group').addClass('has-error');
				$("#bloqueErrorEmail").html("Email is required");
				enviar = false;
			}

			if(enviar) {
				$.post("../ajax/admin/password.php", { email: email }, function(data) {
					console.log("Error: " + data.error);
					console.log("Mensaje: " + data.mensaje);

					if(data.error) {
						$("#password-error").removeClass('hidden').html(data.mensaje);
					} else {
						location.href = "index.php";
					}
				}, "json");
			}
		});
  </script>
</body>
</html>