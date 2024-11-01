$(document).ready(function () {
	$('.scrollbar_wrap').perfectScrollbar({
          wheelSpeed: 20,
          wheelPropagation: false,
		  minScrollbarLength: 20,
		  suppressScrollX: true,
		  useKeyboard: true
    });



// popup_cross_overlay
	$(function () {                                       
		p_cross = $('.popup_cross_overlay')
		$('.popup_toggle_cross').click(function() {
			p_cross.css('left', '0')
		})
		p_cross.click(function(event) {
			e = event || window.event
			if (e.target == this) {
				$(p_cross).css('left', '-9999px')
			}
		})
		$('.popup_cross_close').click(function() {
			$(p_cross).css('left', '-9999px')
		});
	});                

	// popup_cross
		$('select').selectbox();
		
		var popupSlider = $('.popup_slider').bxSlider({
			slideWidth: 140,
			minSlides: 2,
			maxSlides: 5,
			moveSlides: 1,
			slideMargin: 10,
			pager: false,
			autoControls: false
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




// popup_graph_wrap     	
	$(function () {  
		p_graph = $('.popup_graph_wrap')
		$('.popup_toggle_graph').click(function() {
			p_graph.toggleClass('opened_graph');
		});           
	});
	
	// popup_graph
		$('.image_tab').on('click', function () {
			if (!($(this).hasClass('checked'))) {
				$('.image_tab').removeClass('checked');
				$(this).addClass('checked');
					return false;
				}
		});
		
		// tabs
		$( "#graph_tabs" ).tabs();
		
		// graph_content_block_main (skrollTop)
		$('#graph_subtabs_stats').onePageNav();
		$('#graph_subtabs_trends').onePageNav();
		$('#graph_subtabs_segmentations').onePageNav();
		$('#graph_subtabs_content').onePageNav();
		
	
	
	



});



