var main = function() {

  $('.article').click(function() {
    $('.article').removeClass('current');
    $('.pop').hide(500);
	var nextArticle = $(this).next();

    $(this).addClass('current');
	$('#pop_close').show(500);
    nextArticle.show(500);
  });
  
  $('#pop_close').click(function() {
    $('.pop').hide(500);
	$('#pop_close').hide(500);
  });
};

$(document).ready(main);