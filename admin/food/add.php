<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");

// Clases
require("../../clases/clase_restaurante.php");

// Objetos
$restaurante = new Restaurante($conexion);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Food :: Delivery Troop</title>
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
				<h1>Add Food</h1>
				<ol class="breadcrumb">
				  <li><a href="index.php">Food</a></li>
				  <li class="active">Add Food</li>
				</ol>
        <form id="form_insertar" name="form_insertar" method="post" enctype="multipart/form-data">
  				<div class="panel panel-default">
  				  <div class="panel-heading">Add Food</div>
  				  <div class="panel-body">
          		<div id="error" class="alert alert-danger hidden" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <i class="fa fa-times"></i> <span id="msjError">Error</span>
              </div>
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <label for="tipo" class="sr-only">Type:</label>
                  <select name="tipo" class="form-control" >
                    <option value="" selected>Select Type</option>
                    <option value="1">Restaurants</option>
                    <option value="2">Drinks</option>
                    <option value="3">Others</option>
                  </select>
                  <span id="bloqueErrorTipo" class="help-block"></span>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" id="opcion">&nbsp;</div>
              </div>
              <div class="row">
              	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
            			<label for="nombre" class="sr-only">Name:</label>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-tags"></i></div>
                    <input type="text" class="form-control" name="nombre" placeholder="Name" aria-describedby="bloqueErrorNombre"  />
                  </div>
                  <span id="bloqueErrorNombre" class="help-block"></span>
            		</div>
            		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <label for="resumen" class="sr-only">Resume:</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="resumen" placeholder="Resumen" aria-describedby="bloqueErrorResumen"  />
                    <div class="input-group-addon"><i class="fa fa-file"></i></div>
                  </div>
                  <span id="bloqueErrorResumen" class="help-block"></span>
            		</div>
              </div>
              <div class="row">
                <div class="col-xs-12 form-group has-feedback">
                  <label for="descripcion" class="sr-only">Description:</label>
                  <textarea name="descripcion" class="form-control textarea" cols="30" rows="10" placeholder="Enter text ..." aria-describedby="bloqueErrorDescripcion"></textarea>
                  <span id="bloqueErrorDescripcion" class="help-block"></span>
                </div>
              </div>
          		<div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <div class="radio-inline">
                    <label><input type="radio" name="recomendado" value="1" required /> Recommended</label>
                  </div>
                  <div class="radio-inline">
                    <label><input type="radio" name="recomendado" value="0" checked /> Not Recommended</label>
                  </div>
                </div>
          			<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
            			<label for="imagen" class="sr-only">Picture:</label>
            			<div class="input-group">
                    <input type="file" class="form-control" name="imagen" placeholder="Picture" />
            				<div class="input-group-addon"><i class="fa fa-camera"></i></div>
            			</div>
            		</div>
          		</div>
  				  </div>
  				</div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="pull-left">Presentations</div>
              <div class="pull-right">
                <button type="button" id="agregar-presentacion" class="btn btn-success"><i class="fa fa-plus"></i> Add Presentation</button>
              </div>
              <div class="clearfix"></div>
            </div>
            <table id="presentaciones" class="table">
              <thead>
                <tr>
                  <th width="30%">Option 1</th>
                  <th width="30%">Option 2</th>
                  <th width="30%">Price $</th>
                  <th width="10%">&nbsp;</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div class="row text-center">
            <button type="submit" class="btn btn-primary">Add Restaurant</button>
          </div>
        </form>
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
  <script src="../../js/admin_food.js"></script>
  <script>
	  $(document).ready(function() {
      var op1 = '';
      var op2 = '';
      var $campoTipo = $(this).find('select[name="tipo"]');

      $.post("../../ajax/admin/opciones1.php", function(data) {
        op1 = data;
      });

      $.post("../../ajax/admin/opciones2.php", function(data) {
        op2 = data;
      });

      $campoTipo.change(function() {
        var valor = $(this).val();

        if(valor == 1) {
          $.post("../../ajax/admin/restaurants1.php", function(data) {
            $('#opcion').html(data);
          });
        }

        if(valor > 1) {
          $.post("../../ajax/admin/categories1.php", { tipo: valor }, function(data) {
            $('#opcion').html(data);
          });
        }
      });

      $('.textarea').wysihtml5();

      $('#agregar-presentacion').click(function() {
        var fila = '<tr>';
        fila += '<td>' + op1 + '</td>';
        fila += '<td>' + op2 + '</td>';
        fila += '<td><input type="text" class="form-control text-right" name="precio[]" placeholder="0.00" value="0.00" /></td>';
        fila += '<td class="text-center"><a href="#" class="eliminar-presentacion"><i class="icono fa fa-remove"></i></a></td>';
        fila += '</tr>';

        $('#presentaciones > tbody').append(fila);
      });

      $(document).on('click', '.eliminar-presentacion', function (ev) {
        ev.preventDefault();
        $(this).closest('tr').remove();
      });
    });
  </script>
</body>
</html>