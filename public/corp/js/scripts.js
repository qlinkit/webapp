$(document).ready(function($) {
	// escondemos todo:
  $('#faq-accordion').find('.faq-toggle').click(function(){

    //Expand or collapse this panel
    $(this).next().slideToggle('fast');

    //Hide the other panels
    $(".faq-content").not($(this).next()).slideUp('fast');

  });
});
