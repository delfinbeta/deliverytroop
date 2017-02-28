<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button id="botonMenu" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menuWeb" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
			<!-- <a class="navbar-brand" href="<$GLOBALS['domain_root']?>/index.php">
				<img src="<$GLOBALS['domain_root']?>/img/DeliveryTroop.svg" alt="Delivery Troop" title="Delivery Troop" class="logo" />
			</a> -->
		</div>
		<div id="menuWeb" class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li <?=$menu[0]?>><a href="<?=$GLOBALS['domain_root']?>/index.php">Home</a></li>
				<li <?=$menu[1]?>><a href="<?=$GLOBALS['domain_root']?>/services.php">Services</a></li>
				<li <?=$menu[2]?>><a href="<?=$GLOBALS['domain_root']?>/restaurants.php">ORDER NOW</a></li>
				<li <?=$menu[3]?>><a href="<?=$GLOBALS['domain_root']?>/contact.php">Contact</a></li>
			</ul>
		</div>
	</div>
</nav>