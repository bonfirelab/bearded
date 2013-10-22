jQuery(document).ready(function($) {
	$('#menu-toggle').click(function(e){
		$(this).toggleClass('active').next().toggleClass('active');
		e.preventDefault();
	});

	if($('#featured-slider').length > 0 ) {

		var child = $('#featured-slider').find('.slide-item .slide-caption');
		child.each(function(){
			var child_h = $(this).outerHeight();
			var child_more_h = 0;
			if($(this).find('.slide-more').length > 0 ){
				child_more_h += 49;
			}
			$(this).css({
				'top' : '50%',
				'margin-top' : -((child_h - child_more_h) / 2) 
			});
		});

		$('#featured-slider').bxSlider({
			slideSelector: '.slide-item',
			pager: false,
			controls: true,
			nextSelector: "#featured-slider-control",
			prevSelector: "#featured-slider-control",
			autoStart: false,
			mode: 'fade',
			nextText: '<i class="icon-chevron-right"></i>',
			prevText: '<i class="icon-chevron-left"></i>',
			onSliderLoad: function( index ) {
				$(this.slideSelector).eq(index).delay(80).queue(function(){
					$(this).addClass('active');
					$(this).dequeue();
				});
			},
			onSlideBefore: function($elem, oldI, newI){
				$(this.slideSelector).eq(oldI).removeClass('active');
			},
			onSlideAfter: function($elem, oldI, newI){
				$(this.slideSelector).eq(newI).addClass('active');
			}
		});

	}

	if ( $('.bearded-gallery-carousel').length > 0 ) {

		$('.bearded-gallery-carousel').each(function(){

			var id = $(this).attr('id');

			$('#' + id ).bxSlider({
				slideSelector: '.gallery-carousel-item',
				pager: false,
				controls: true,
				nextSelector: "#"+id+"-control",
				prevSelector: "#"+id+"-control",
				autoStart: false,
				mode: 'fade',
				adaptiveHeight: true,
				nextText: '<i class="icon-chevron-right"></i>',
				prevText: '<i class="icon-chevron-left"></i>',
			});
		});
	}

	$('.bearded-tip').each(function( event ){

		$(this).click(function( event ){

			if(!($(this).hasClass('tip-active'))) {
				$(this).addClass('tip-active');

				var tooltip = '<div class="bearded-tooltip" data-tip="'+ $(this).attr('id') +'"></div>';
		        var content = $(this).attr('title');
		        $(this).removeAttr('title');
		        
		        var offset = $(this).offset();
		        var mousex = offset.left + $(this).outerWidth() + 8; //Get X coordinates
		        var mousey = offset.top ; //Get Y coordinates
		        console.log($(tooltip).outerHeight());
		        $(tooltip).text(content).appendTo('body').offset({ top: mousey, left: mousex }).fadeIn();

			} else {

				$(this).removeClass('tip-active');
				var $t = $(this);

				$('.bearded-tooltip').each(function(){
					var datatip = $(this).data('tip');
					var content = $(this).text();
					if(datatip == $t.attr('id')) {
						$(this).fadeOut().text('').remove();
						$t.attr('title', content);
					}
				});

			}
		});
	});
	

	// cache container
	var $container = $('#portfolio-isotope');
	var $filter = $('#isotope-filters a');
	// Vars

		// Needed functions
		var getColWidth4 = function() {
			var width,
				windowWidth = $(window).width();
			
			if( windowWidth <= 480 ) {
				width = Math.floor( $container.width() );
			} else if( windowWidth <= 768 ) {
				width = Math.floor( $container.width() / 2 );
			} else {
				width = Math.floor( $container.width() / 4 );
			}

			return width;
		}

		var getColWidth3 = function() {
			var width,
				windowWidth = $(window).width();
			
			if( windowWidth <= 480 ) {
				width = Math.floor( $container.width() );
			} else if( windowWidth <= 768 ) {
				width = Math.floor( $container.width() / 2 );
			} else {
				width = Math.floor( $container.width() / 3 );
			}

			return width;
		}

		function setWidths( col ) {
			if( col == 4) {
				var colWidth = getColWidth4();
				$container.children().css({ width: colWidth });
			} else {
				var colWidth = getColWidth3();
				$container.children().css({ width: colWidth });
			}
		}

		if($('.portfolio-4-columns').length > 0) {
			setWidths(4);

			$container.imagesLoaded( function() {
				$container.isotope({
					resizable: false,
					masonry: {
						columnWidth: getColWidth4()
					}
				});
			});

			$(window).smartresize(function() {
				setWidths();
				$container.isotope({
					masonry: {
						columnWidth: getColWidth4()
					}
				});
				
			});

		} else {
			setWidths(3);
			$container.imagesLoaded( function() {
				$container.isotope({
					resizable: false,
					masonry: {
						columnWidth: getColWidth3()
					}
				});
			});

			$(window).smartresize(function() {
				setWidths();
				$container.isotope({
					masonry: {
						columnWidth: getColWidth3()
					}
				});
				
			});
		}


		$filter.click(function(e) {
			
			// do the filter
			var selector = $(this).attr('data-filter');
			$container.isotope({ filter: '.' + selector });

			// update filter class
			$filter.removeClass('active');
			$(this).addClass('active');

			// prevent default click
			e.preventDefault();
			return false;
		});

		if ($('.featured-image iframe').length > 0) {
	        if ($.fn.fitVids) {
	            $('.featured-image iframe').fitVids();
	        }
	    }
		
		$("iframe[src^='http://www.youtube.com'], object, embed").each(function () {
            var url = $(this).attr("src");
            if ($(this).attr("src").indexOf("?") > 0) {
                $(this).attr({
                    "src": url + "&wmode=transparent&html5=1",
                    "wmode": "Opaque"
                })
            } else {
                $(this).attr({
                    "src": url + "?wmode=transparent&html5=1",
                    "wmode": "Opaque"
                })
            }
        });
});