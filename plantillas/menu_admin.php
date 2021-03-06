<div class="col-sm-3 col-md-2 sidebar-offcanvas">
	<div class="logo">
		<a href="<?=$GLOBALS['domain_root']?>/admin/index.php"><img src="<?=$GLOBALS['domain_root']?>/img/deliverytroop.png" alt="Delivery Troop" title="Delivery Troop" class="img-responsive" /></a>
	</div>
	<div class="perfil">
		<div class="perfil-marco text-center">
			<img src="<?=$_SESSION['usuario_rutafoto']?>" alt="<?=$_SESSION['usuario_nombre'].' '.$_SESSION['usuario_apellido']?>" title="<?=$_SESSION['usuario_nombre'].' '.$_SESSION['usuario_apellido']?>" class="img-circle perfil-img" />
		</div>
		<div class="perfil-info">
			Welcome
			<h4><?=$_SESSION['usuario_nombre'].' '.$_SESSION['usuario_apellido']?></h4>
		</div>
		<div class="clearfix"></div>
	</div>
	<ul class="nav nav-pills nav-stacked">
		<li>&nbsp;</li>
	</ul>
	<ul class="nav nav-pills nav-stacked">
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/categories"><i class="fa fa-tags pull-right"></i> Categories</a></li>
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/options1"><i class="fa fa-tags pull-right"></i> Options 1</a></li>
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/options2"><i class="fa fa-tags pull-right"></i> Options 2</a></li>
	</ul>
	<ul class="nav nav-pills nav-stacked">
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/zipcodes"><i class="fa fa-map-marker pull-right"></i> Zipcodes</a></li>
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/hotels"><i class="fa fa-bed pull-right"></i> Hotels</a></li>
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/restaurants"><i class="fa fa-coffee pull-right"></i> Restaurants</a></li>
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/food"><i class="fa fa-cutlery pull-right"></i> Food</a></li>
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/orders"><i class="fa fa-car pull-right"></i> Orders</a></li>
	</ul>
	<ul class="nav nav-pills nav-stacked">
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/users"><i class="fa fa-users pull-right"></i> Admin Users</a></li>
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/contents"><i class="fa fa-file-text pull-right"></i> Contents</a></li>
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/messages"><i class="fa fa-envelope pull-right"></i> Messages</a></li>
	</ul>
	<ul class="nav nav-pills nav-stacked">
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/profile.php"><i class="fa fa-user pull-right"></i> Profile</a></li>
		<li><a href="<?=$GLOBALS['domain_root']?>/admin/logout.php"><i class="fa fa-sign-out pull-right"></i> Logout</a></li>
	</ul>
</div>