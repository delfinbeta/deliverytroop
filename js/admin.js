$(document).ready(function () {
  /*--------------------------------------------------
		Establecer Altos de las Columnas del Layout
	  --------------------------------------------------*/
  $('.sidebar-offcanvas').css('min-height', $(window).height());

  var bodyHeight = $('body').outerHeight();
  var leftColHeight = $('.sidebar-offcanvas').height();
  var contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

  $('.main').css('min-height', contentHeight);

	/*--------------------------------------------------
		Botón Menú Responsive
	  --------------------------------------------------*/
  $('[data-toggle="offcanvas"]').click(function () {
    $('.row-offcanvas').toggleClass('active')
  });
});