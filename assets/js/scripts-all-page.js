$(document).ready(function ($) {	   
	    $('.scrollbar_wrap').perfectScrollbar({
          wheelSpeed: 20,
          wheelPropagation: false,
		  minScrollbarLength: 20,
		  suppressScrollX: true,
		  useKeyboard: true
        });

$(function () {
  $('.popup_slider').bxSlider({
    slideWidth: 140,
    minSlides: 2,
    maxSlides: 5,
    moveSlides: 1,
    slideMargin: 10,
	pager: false,
	autoControls: false
  });
});



// popup_overlay
$(function () {                                       
	p = $('.popup_overlay')
	$('#popup_toggle_cross').click(function() {
		p.css('display', 'block')
	})
	p.click(function(event) {
		e = event || window.event
		if (e.target == this) {
			$(p).css('display', 'none')
		}
	})
	$('.popup_close').click(function() {
		p.css('display', 'none')
	});
});                






//popup_cross




$(function () {
    $('select').selectbox();
});

$(function () {
	var name = 'td Bank';
		$('#search_criteria').attr('value', name).focus(function(){
			if ($(this).val() == name){
				$(this).attr('value', '')
			}
		}).blur(function(){
			if ($(this).val() == ''){
				$(this).attr('value', name);
			}
		});
});










});