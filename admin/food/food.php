<?php
require("../../configuracion/inicio_admin.php");
require("../sesion.php");

// Clases
require("../../clases/clase_producto.php");
require("../../clases/clase_restaurante.php");
require("../../clases/clase_presentacion.php");
require("../../clases/clase_opcion1.php");
require("../../clases/clase_opcion2.php");

// Objetos
$producto = new Producto($conexion);
$restaurante = new Restaurante($conexion);
$presentacion = new Presentacion($conexion);
$opcion1 = new Opcion1($conexion);
$opcion2 = new Opcion2($conexion);

if(isset($_GET['id'])) { $id_producto = $_GET['id']; } else { $id_producto = 0; }
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
				<h1>Food</h1>
				<ol class="breadcrumb">
				  <li><a href="index.php">Food</a></li>
				  <li class="active">Food</li>
				</ol>
				<?php if($producto->datos($id_producto)) {
								if($producto->imagen == '') { $ruta_img = $GLOBALS['domain_root']."/img/no_img.jpg"; }
								else { $ruta_img = $GLOBALS['domain_root']."/archivos_productos/".$producto->imagen; }

								$id_restaurante = $producto->obtener_restaurante();

								$marca = array('', '');
                $pos = $producto->recomendado;
                $marca[$pos] = 'checked'; ?>
				<div class="panel panel-default">
					<div class="panel-heading">Edit:</div>
					<div class="panel-body">
						<div class="col-md-3">
							<img src="<?=$ruta_img?>" alt="<?=$producto->nombre?>" title="<?=$producto->nombre?>" class="img-responsive" />
						</div>
						<div class="col-md-9">
							<form id="form_modificar" name="form_modificar" method="post" enctype="multipart/form-data">
	          		<div id="error" class="alert alert-danger hidden" role="alert">
	                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	                <i class="fa fa-times"></i> <span id="msjError">Error</span>
	              </div>
	              <input type="hidden" name="id" value="<?=$id_producto?>" />
	              <div class="row">
	              	<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	            			<label for="restaurante">Restaurant:</label>
	            			<select name="restaurante" class="form-control">
	                    <?php // Listar Restaurantes
	                          $listado_restaurantes = $restaurante->listado(0, '', 1);
	                          $total_restaurantes = $restaurante->total_listado(0, '', 1);

	                          if($total_restaurantes > 0) {
	                            foreach($listado_restaurantes as $reg_restaurante) { ?>
	                    <option value="<?=$reg_restaurante->obtener_id()?>"><?=$reg_restaurante->nombre?></option>
	                    <?php   }
	                          } ?>

	                    <?php // Listar Restaurantes
	                          $listado_restaurantes = $restaurante->listado(1, 1);
	                          $total_restaurantes = $restaurante->total_listado(1, 1);

	                          if($total_restaurantes > 0) {
	                            foreach($listado_restaurantes as $reg_restaurante) { ?>
	                    <option value="<?=$reg_restaurante->obtener_id()?>" <?php if($reg_restaurante->obtener_id() == $id_restaurante) { echo 'selected'; } ?>><?=$reg_restaurante->nombre?></option>
	                    <?php   }
	                          } ?>
	                  </select>
	            		</div>
	            		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	            			<label for="nombre">Name:</label>
	            			<div class="input-group">
	            				<input type="text" class="form-control" name="nombre" placeholder="Name" value="<?=$producto->nombre?>" aria-describedby="bloqueErrorNombre"  />
	            				<div class="input-group-addon"><i class="fa fa-tags"></i></div>
	            			</div>
	            			<span id="bloqueErrorNombre" class="help-block"></span>
	            		</div>
	              </div>
	              <div class="row">
	                <div class="col-xs-12 form-group has-feedback">
	                  <label for="resumen">Resume:</label>
	                  <div class="input-group">
	                    <div class="input-group-addon"><i class="fa fa-file"></i></div>
	                    <input type="text" class="form-control" name="resumen" placeholder="Resumen" value="<?=$producto->resumen?>" aria-describedby="bloqueErrorResumen"  />
	                  </div>
	                  <span id="bloqueErrorResumen" class="help-block"></span>
	                </div>
	          		</div>
	              <div class="row">
	                <div class="col-xs-12 form-group has-feedback">
	                  <label for="descripcion">Description:</label>
	                  <textarea name="descripcion" class="form-control textarea" cols="30" rows="10" placeholder="Enter text ..." aria-describedby="bloqueErrorDescripcion"><?=$producto->descripcion?></textarea>
	                  <span id="bloqueErrorDescripcion" class="help-block"></span>
	                </div>
	              </div>
	          		<div class="row">
	          			<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	          				<p>&nbsp;</p>
	                  <div class="radio-inline">
	                    <label><input type="radio" name="recomendado" value="1" <?=$marca[1]?> required /> Recommended</label>
	                  </div>
	                  <div class="radio-inline">
	                    <label><input type="radio" name="recomendado" value="0" <?=$marca[0]?> /> Not Recommended</label>
	                  </div>
	                </div>
	          			<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
	            			<label for="imagen">Picture:</label>
	            			<div class="input-group">
	            				<div class="input-group-addon"><i class="fa fa-camera"></i></div>
	            				<input type="file" class="form-control" name="imagen" placeholder="Picture" />
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

				<form id="form_presentacionesM" name="form_presentacionesM" method="post" enctype="multipart/form-data">
					<input type="hidden" name="producto" value="<?=$id_producto?>" />
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
								<?php // Listar Presentaciones
											$listado_presentaciones = $presentacion->listado($id_producto, 0, 0);
											$total_presentaciones = $presentacion->total_listado($id_producto, 0, 0);

											if($total_presentaciones > 0) {
												foreach($listado_presentaciones as $reg_presentacion) {
													$id_opc1 = $reg_presentacion->obtener_opcion1();
													$id_opc2 = $reg_presentacion->obtener_opcion2(); ?>
								<tr>
									<td>
										<select name="opcion1[]" class="form-control">
											<option value="0">Select</option>
											<?php // Listar Opciones 1
														$listado_opciones1 = $opcion1->listado(1);
														$total_opciones1 = $opcion1->total_listado(1);

														if($total_opciones1 > 0) {
															foreach($listado_opciones1 as $reg_opcion1) { ?>
											<option value="<?=$reg_opcion1->obtener_id()?>" <?php if($reg_opcion1->obtener_id() == $id_opc1) { echo 'selected'; } ?>><?=$reg_opcion1->nombre?></option>
											<?php 	}
														} ?>
										</select>
									</td>
									<td>
										<select name="opcion2[]" class="form-control">
											<option value="0">Select</option>
											<?php // Listar Opciones 1
														$listado_opciones2 = $opcion2->listado(1);
														$total_opciones2 = $opcion2->total_listado(1);

														if($total_opciones2 > 0) {
															foreach($listado_opciones2 as $reg_opcion2) { ?>
											<option value="<?=$reg_opcion2->obtener_id()?>" <?php if($reg_opcion2->obtener_id() == $id_opc2) { echo 'selected'; } ?>><?=$reg_opcion2->nombre?></option>
											<?php 	}
														} ?>
										</select>
									</td>
									<td>
										<input type="text" class="form-control text-right" name="precio[]" placeholder="0.00" value="<?=$reg_presentacion->precio?>" />
									</td>
									<td class="text-center"><a href="#" class="eliminar-presentacion"><i class="icono fa fa-remove"></i></a></td>
								</tr>
								<?php 	}
											} ?>
							</tbody>
						</table>
						<div class="row text-center">
      				<button type="submit" class="btn btn-primary">Save</button>
        		</div>
					</div>
				</form>
				<?php } else { ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <i class="fa fa-times"></i> Error: <?=$producto->error?>
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
  <script src="../../js/admin_food.js"></script>
  <script>
	  $(document).ready(function() {
	  	var op1 = '';
    	var op2 = '';

      $.post("../../ajax/admin/opciones1.php", function(data) {
      	op1 = data;
      });

      $.post("../../ajax/admin/opciones2.php", function(data) {
      	op2 = data;
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