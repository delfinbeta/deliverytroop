$(document).ready(function () {
  /*--------------------------------------------------
		Establecer Altos de las Columnas del Layout
	  --------------------------------------------------*/
  $('.sidebar-offcanvas').css('min-height', $(window).height());
  
  var leftColHeight = $('.sidebar-offcanvas').height();

  $('.main').css('min-height', leftColHeight);

	/*--------------------------------------------------
		Botón Menú Responsive
	  --------------------------------------------------*/
  $('[data-toggle="offcanvas"]').click(function () {
    $('.row-offcanvas').toggleClass('active')
  });
});