// Tiptip
(function($){$.fn.tipTip=function(options){var defaults={activation:"hover",keepAlive:false,maxWidth:"200px",edgeOffset:3,defaultPosition:"bottom",delay:400,fadeIn:200,fadeOut:200,attribute:"title",content:false,enter:function(){},exit:function(){}};var opts=$.extend(defaults,options);if($("#tiptip_holder").length<=0){var tiptip_holder=$('<div id="tiptip_holder" style="max-width:'+opts.maxWidth+';"></div>');var tiptip_content=$('<div id="tiptip_content"></div>');var tiptip_arrow=$('<div id="tiptip_arrow"></div>');$("body").append(tiptip_holder.html(tiptip_content).prepend(tiptip_arrow.html('<div id="tiptip_arrow_inner"></div>')))}else{var tiptip_holder=$("#tiptip_holder");var tiptip_content=$("#tiptip_content");var tiptip_arrow=$("#tiptip_arrow")}return this.each(function(){var org_elem=$(this);if(opts.content){var org_title=opts.content}else{var org_title=org_elem.attr(opts.attribute)}if(org_title!=""){if(!opts.content){org_elem.removeAttr(opts.attribute)}var timeout=false;if(opts.activation=="hover"){org_elem.hover(function(){active_tiptip()},function(){if(!opts.keepAlive){deactive_tiptip()}});if(opts.keepAlive){tiptip_holder.hover(function(){},function(){deactive_tiptip()})}}else if(opts.activation=="focus"){org_elem.focus(function(){active_tiptip()}).blur(function(){deactive_tiptip()})}else if(opts.activation=="click"){org_elem.click(function(){active_tiptip();return false}).hover(function(){},function(){if(!opts.keepAlive){deactive_tiptip()}});if(opts.keepAlive){tiptip_holder.hover(function(){},function(){deactive_tiptip()})}}function active_tiptip(){opts.enter.call(this);tiptip_content.html(org_title);tiptip_holder.hide().removeAttr("class").css("margin","0");tiptip_arrow.removeAttr("style");var top=parseInt(org_elem.offset()['top']);var left=parseInt(org_elem.offset()['left']);var org_width=parseInt(org_elem.outerWidth());var org_height=parseInt(org_elem.outerHeight());var tip_w=tiptip_holder.outerWidth();var tip_h=tiptip_holder.outerHeight();var w_compare=Math.round((org_width-tip_w)/2);var h_compare=Math.round((org_height-tip_h)/2);var marg_left=Math.round(left+w_compare);var marg_top=Math.round(top+org_height+opts.edgeOffset);var t_class="";var arrow_top="";var arrow_left=Math.round(tip_w-12)/2;if(opts.defaultPosition=="bottom"){t_class="_bottom"}else if(opts.defaultPosition=="top"){t_class="_top"}else if(opts.defaultPosition=="left"){t_class="_left"}else if(opts.defaultPosition=="right"){t_class="_right"}var right_compare=(w_compare+left)<parseInt($(window).scrollLeft());var left_compare=(tip_w+left)>parseInt($(window).width());if((right_compare&&w_compare<0)||(t_class=="_right"&&!left_compare)||(t_class=="_left"&&left<(tip_w+opts.edgeOffset+5))){t_class="_right";arrow_top=Math.round(tip_h-13)/2;arrow_left=-12;marg_left=Math.round(left+org_width+opts.edgeOffset);marg_top=Math.round(top+h_compare)}else if((left_compare&&w_compare<0)||(t_class=="_left"&&!right_compare)){t_class="_left";arrow_top=Math.round(tip_h-13)/2;arrow_left=Math.round(tip_w);marg_left=Math.round(left-(tip_w+opts.edgeOffset+5));marg_top=Math.round(top+h_compare)}var top_compare=(top+org_height+opts.edgeOffset+tip_h+8)>parseInt($(window).height()+$(window).scrollTop());var bottom_compare=((top+org_height)-(opts.edgeOffset+tip_h+8))<0;if(top_compare||(t_class=="_bottom"&&top_compare)||(t_class=="_top"&&!bottom_compare)){if(t_class=="_top"||t_class=="_bottom"){t_class="_top"}else{t_class=t_class+"_top"}arrow_top=tip_h;marg_top=Math.round(top-(tip_h+5+opts.edgeOffset))}else if(bottom_compare|(t_class=="_top"&&bottom_compare)||(t_class=="_bottom"&&!top_compare)){if(t_class=="_top"||t_class=="_bottom"){t_class="_bottom"}else{t_class=t_class+"_bottom"}arrow_top=-12;marg_top=Math.round(top+org_height+opts.edgeOffset)}if(t_class=="_right_top"||t_class=="_left_top"){marg_top=marg_top+5}else if(t_class=="_right_bottom"||t_class=="_left_bottom"){marg_top=marg_top-5}if(t_class=="_left_top"||t_class=="_left_bottom"){marg_left=marg_left+5}tiptip_arrow.css({"margin-left":arrow_left+"px","margin-top":arrow_top+"px"});tiptip_holder.css({"margin-left":marg_left+"px","margin-top":marg_top+"px"}).attr("class","tip"+t_class);if(timeout){clearTimeout(timeout)}timeout=setTimeout(function(){tiptip_holder.stop(true,true).fadeIn(opts.fadeIn)},opts.delay)}function deactive_tiptip(){opts.exit.call(this);if(timeout){clearTimeout(timeout)}tiptip_holder.fadeOut(opts.fadeOut)}}})}})(jQuery);
// WayPoint
(function(){var t=[].indexOf||function(t){for(var e=0,n=this.length;e<n;e++){if(e in this&&this[e]===t)return e}return-1},e=[].slice;(function(t,e){if(typeof define==="function"&&define.amd){return define("waypoints",["jquery"],function(n){return e(n,t)})}else{return e(t.jQuery,t)}})(this,function(n,r){var i,o,l,s,f,u,c,a,h,d,p,y,v,w,g,m;i=n(r);a=t.call(r,"ontouchstart")>=0;s={horizontal:{},vertical:{}};f=1;c={};u="waypoints-context-id";p="resize.waypoints";y="scroll.waypoints";v=1;w="waypoints-waypoint-ids";g="waypoint";m="waypoints";o=function(){function t(t){var e=this;this.$element=t;this.element=t[0];this.didResize=false;this.didScroll=false;this.id="context"+f++;this.oldScroll={x:t.scrollLeft(),y:t.scrollTop()};this.waypoints={horizontal:{},vertical:{}};this.element[u]=this.id;c[this.id]=this;t.bind(y,function(){var t;if(!(e.didScroll||a)){e.didScroll=true;t=function(){e.doScroll();return e.didScroll=false};return r.setTimeout(t,n[m].settings.scrollThrottle)}});t.bind(p,function(){var t;if(!e.didResize){e.didResize=true;t=function(){n[m]("refresh");return e.didResize=false};return r.setTimeout(t,n[m].settings.resizeThrottle)}})}t.prototype.doScroll=function(){var t,e=this;t={horizontal:{newScroll:this.$element.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.$element.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};if(a&&(!t.vertical.oldScroll||!t.vertical.newScroll)){n[m]("refresh")}n.each(t,function(t,r){var i,o,l;l=[];o=r.newScroll>r.oldScroll;i=o?r.forward:r.backward;n.each(e.waypoints[t],function(t,e){var n,i;if(r.oldScroll<(n=e.offset)&&n<=r.newScroll){return l.push(e)}else if(r.newScroll<(i=e.offset)&&i<=r.oldScroll){return l.push(e)}});l.sort(function(t,e){return t.offset-e.offset});if(!o){l.reverse()}return n.each(l,function(t,e){if(e.options.continuous||t===l.length-1){return e.trigger([i])}})});return this.oldScroll={x:t.horizontal.newScroll,y:t.vertical.newScroll}};t.prototype.refresh=function(){var t,e,r,i=this;r=n.isWindow(this.element);e=this.$element.offset();this.doScroll();t={horizontal:{contextOffset:r?0:e.left,contextScroll:r?0:this.oldScroll.x,contextDimension:this.$element.width(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:r?0:e.top,contextScroll:r?0:this.oldScroll.y,contextDimension:r?n[m]("viewportHeight"):this.$element.height(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};return n.each(t,function(t,e){return n.each(i.waypoints[t],function(t,r){var i,o,l,s,f;i=r.options.offset;l=r.offset;o=n.isWindow(r.element)?0:r.$element.offset()[e.offsetProp];if(n.isFunction(i)){i=i.apply(r.element)}else if(typeof i==="string"){i=parseFloat(i);if(r.options.offset.indexOf("%")>-1){i=Math.ceil(e.contextDimension*i/100)}}r.offset=o-e.contextOffset+e.contextScroll-i;if(r.options.onlyOnScroll&&l!=null||!r.enabled){return}if(l!==null&&l<(s=e.oldScroll)&&s<=r.offset){return r.trigger([e.backward])}else if(l!==null&&l>(f=e.oldScroll)&&f>=r.offset){return r.trigger([e.forward])}else if(l===null&&e.oldScroll>=r.offset){return r.trigger([e.forward])}})})};t.prototype.checkEmpty=function(){if(n.isEmptyObject(this.waypoints.horizontal)&&n.isEmptyObject(this.waypoints.vertical)){this.$element.unbind([p,y].join(" "));return delete c[this.id]}};return t}();l=function(){function t(t,e,r){var i,o;r=n.extend({},n.fn[g].defaults,r);if(r.offset==="bottom-in-view"){r.offset=function(){var t;t=n[m]("viewportHeight");if(!n.isWindow(e.element)){t=e.$element.height()}return t-n(this).outerHeight()}}this.$element=t;this.element=t[0];this.axis=r.horizontal?"horizontal":"vertical";this.callback=r.handler;this.context=e;this.enabled=r.enabled;this.id="waypoints"+v++;this.offset=null;this.options=r;e.waypoints[this.axis][this.id]=this;s[this.axis][this.id]=this;i=(o=this.element[w])!=null?o:[];i.push(this.id);this.element[w]=i}t.prototype.trigger=function(t){if(!this.enabled){return}if(this.callback!=null){this.callback.apply(this.element,t)}if(this.options.triggerOnce){return this.destroy()}};t.prototype.disable=function(){return this.enabled=false};t.prototype.enable=function(){this.context.refresh();return this.enabled=true};t.prototype.destroy=function(){delete s[this.axis][this.id];delete this.context.waypoints[this.axis][this.id];return this.context.checkEmpty()};t.getWaypointsByElement=function(t){var e,r;r=t[w];if(!r){return[]}e=n.extend({},s.horizontal,s.vertical);return n.map(r,function(t){return e[t]})};return t}();d={init:function(t,e){var r;if(e==null){e={}}if((r=e.handler)==null){e.handler=t}this.each(function(){var t,r,i,s;t=n(this);i=(s=e.context)!=null?s:n.fn[g].defaults.context;if(!n.isWindow(i)){i=t.closest(i)}i=n(i);r=c[i[0][u]];if(!r){r=new o(i)}return new l(t,r,e)});n[m]("refresh");return this},disable:function(){return d._invoke.call(this,"disable")},enable:function(){return d._invoke.call(this,"enable")},destroy:function(){return d._invoke.call(this,"destroy")},prev:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e>0){return t.push(n[e-1])}})},next:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e<n.length-1){return t.push(n[e+1])}})},_traverse:function(t,e,i){var o,l;if(t==null){t="vertical"}if(e==null){e=r}l=h.aggregate(e);o=[];this.each(function(){var e;e=n.inArray(this,l[t]);return i(o,e,l[t])});return this.pushStack(o)},_invoke:function(t){this.each(function(){var e;e=l.getWaypointsByElement(this);return n.each(e,function(e,n){n[t]();return true})});return this}};n.fn[g]=function(){var t,r;r=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(d[r]){return d[r].apply(this,t)}else if(n.isFunction(r)){return d.init.apply(this,arguments)}else if(n.isPlainObject(r)){return d.init.apply(this,[null,r])}else if(!r){return n.error("jQuery Waypoints needs a callback function or handler option.")}else{return n.error("The "+r+" method does not exist in jQuery Waypoints.")}};n.fn[g].defaults={context:r,continuous:true,enabled:true,horizontal:false,offset:0,triggerOnce:false};h={refresh:function(){return n.each(c,function(t,e){return e.refresh()})},viewportHeight:function(){var t;return(t=r.innerHeight)!=null?t:i.height()},aggregate:function(t){var e,r,i;e=s;if(t){e=(i=c[n(t)[0][u]])!=null?i.waypoints:void 0}if(!e){return[]}r={horizontal:[],vertical:[]};n.each(r,function(t,i){n.each(e[t],function(t,e){return i.push(e)});i.sort(function(t,e){return t.offset-e.offset});r[t]=n.map(i,function(t){return t.element});return r[t]=n.unique(r[t])});return r},above:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset<=t.oldScroll.y})},below:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset>t.oldScroll.y})},left:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset<=t.oldScroll.x})},right:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset>t.oldScroll.x})},enable:function(){return h._invoke("enable")},disable:function(){return h._invoke("disable")},destroy:function(){return h._invoke("destroy")},extendFn:function(t,e){return d[t]=e},_invoke:function(t){var e;e=n.extend({},s.vertical,s.horizontal);return n.each(e,function(e,n){n[t]();return true})},_filter:function(t,e,r){var i,o;i=c[n(t)[0][u]];if(!i){return[]}o=[];n.each(i.waypoints[e],function(t,e){if(r(i,e)){return o.push(e)}});o.sort(function(t,e){return t.offset-e.offset});return n.map(o,function(t){return t.element})}};n[m]=function(){var t,n;n=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(h[n]){return h[n].apply(null,t)}else{return h.aggregate.call(null,n)}};n[m].settings={resizeThrottle:100,scrollThrottle:30};return i.load(function(){return n[m]("refresh")})})}).call(this);
(function(){(function(t,n){if(typeof define==="function"&&define.amd){return define(["jquery","waypoints"],n)}else{return n(t.jQuery)}})(this,function(t){var n,s;n={wrapper:'<div class="sticky-wrapper" />',stuckClass:"stuck"};s=function(t,n){t.wrap(n.wrapper);return t.parent()};t.waypoints("extendFn","sticky",function(e){var i,r,a;r=t.extend({},t.fn.waypoint.defaults,n,e);i=s(this,r);a=r.handler;r.handler=function(n){var s,e;s=t(this).children(":first");e=n==="down"||n==="right";s.toggleClass(r.stuckClass,e);i.height(e?s.outerHeight():"");if(a!=null){return a.call(this,n)}};i.waypoint(r);return this.data("stuckClass",r.stuckClass)});return t.waypoints("extendFn","unsticky",function(){this.parent().waypoint("destroy");this.unwrap();return this.removeClass(this.data("stuckClass"))})})}).call(this);

(function($){
	
	// USE STRICT
	"use strict";

	var onReady = {
		init: function(){}
	};
	var onLoad = {
		init: function(){
			bearded.init();
			if ( $('body').hasClass('woocommerce') || $('body').hasClass('woocommerce-page') ) {
				woocommerce.init();				
			}
			if( $('.yith-wcwl-add-to-wishlist').length > 0 ) {
				woocommerce.wishlist();
			}
			if( $('.shop-nav').length > 0 ) {
				bearded.setupWaypoint();
			}
				
		}
	};

	var onResize = {
		init: function(){
			if( $('.shop-nav').length > 0 ) {
				bearded.setupWaypoint();
			}
		}
	};
	
	$(document).ready(onReady.init);
	$(window).load(onLoad.init);
	$(window).resize(onResize.init);
	var bearded = {
		init: function() {
			$('#menu-toggle').click(function(e){
				$(this).toggleClass('active').next().toggleClass('active');
				e.preventDefault();
			});
			this.setTooltip();

			this.setIframe();

			this.setIframe();

			this.setVids();

			this.setTip();

			if( $('#portfolio-shuffle').length > 0 ) {
				this.setShuffle();
			}

			if ( $('.bearded-gallery-carousel').length > 0 ) {
				this.setGallery();
			}
			if($('#featured-slider').length > 0 ) {
				this.setSlider();
			}
		},
		setTooltip: function() {
			$('a.tiptip').tipTip({
				defaultPosition: "top",
				delay: 0
			});
		},
		setIframe: function() {

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
		},
		setVids: function(){
			$('body').fitVids({
				customSelector: "iframe[src^='http://blip.tv']"
			});
		},
		setShuffle: function(){
			var $grid = $('#portfolio-shuffle');
			var $filter = $('#shuffle-filters a');
			var $sizer = $grid.find('.shuffle__sizer');
			var group_filters = [];

			$grid.shuffle({
				speed: 350,
				itemSelector: '.shuffle-elem',
				sizer: $sizer
			});

			// colors
		    $filter.on('click', function (e) {

		    	// prevent default click
				e.preventDefault();

		        var selector = $(this).attr('data-filter');

				// update filter class
				$filter.removeClass('active');
				$(this).addClass('active');

				var groupName = $(this).attr('data-filter');
			    // reshuffle grid
			    $grid.shuffle('shuffle', groupName );
				
				//return false;
		    });
		},
		
	
		setTip: function(){
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
		},
		setSlider: function() {

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
		},
		setGallery: function(){

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
			
		},
		setupWaypoint: function() {
			if( Modernizr.mq( "only screen and (min-width: 768px)" ) ) {
				if( !( $('#navigation').parent().is('.sticky-wrapper') ) ) {
					$('#navigation').waypoint('sticky');
				}
			} else {
				if( $('#navigation').parent().is('.sticky-wrapper') ){
					$('#navigation').waypoint('unsticky');
					$('#navigation').waypoint('destroy');
				}
				
			}
		}
	};

	var woocommerce = {
		init: function(){
			$('#yith-wcwl-popup-message #yith-wcwl-message').html('<i class="icon-magic"></i>' + bearded_woocommerce.i18n_added_wishlist);
			this.reviewModal();
		},
		wishlist: function(){
			this.wishlistTooltip();
			$('.add_to_wishlist').on('click', function() {
				var t = $(this);
				t.addClass('loading');
				t.find('i').attr('class', 'icon-spinner icon-spin');
			}).ajaxSuccess(function(e) {
				$('#yith-wcwl-popup-message #yith-wcwl-message').html('<i class="icon-magic"></i>' + bearded_woocommerce.i18n_added_wishlist);
			});
		},
		reviewModal: function() {
			if( $.fn.prettyPhoto ) {
				$("#review_form_wrapper").hide();
		        $("a.show_review_form").prettyPhoto({
		            social_tools: !1,
		            theme: "pp_woocommerce",
		            horizontal_padding: 40,
		            opacity: .9,
		            deeplinking: !1
		        });
		        window.location.hash == "#review_form" && $("a.show_review_form").trigger("click");
		    }
		},
		wishlistTooltip: function() {
			$('ul.products').find('.add_to_wishlist, .yith-wcwl-wishlistexistsbrowse a, .yith-wcwl-wishlistaddedbrowse a').each(function(e){
				var t = $(this);

				var title = '';
				if( t.hasClass('add_to_wishlist') ) {
					title = bearded_woocommerce.i18n_add_wishlist;
				} else if( t.parent().hasClass('yith-wcwl-wishlistexistsbrowse') ) {
					title = bearded_woocommerce.i18n_exists_wishlist;
				} else if ( t.parent().hasClass('yith-wcwl-wishlistaddedbrowse') ) {
					title = bearded_woocommerce.i18n_added_wishlist;
				}

				t.hover(function(){
					t.addClass('tip-active');
					var tooltip = '<div class="bearded-tooltip tip-top"></div>';
			        
			        t.removeAttr('title');
			        $(tooltip).text(title).appendTo('body');

			        var ttip = $('body').find('.bearded-tooltip');
			        var offset = t.parents('.yith-wcwl-add-to-wishlist').offset();
			        var mousex = offset.left - ttip.outerWidth() / 2 + (t.outerWidth() / 2);
			        var mousey = offset.top - t.outerHeight();

			        $(tooltip).text(title).appendTo('body').offset({ top: mousey, left: mousex }).fadeIn();
				}, function(){

					t.removeClass('tip-active');
					$('.bearded-tooltip').fadeOut().text('').remove();
					t.attr('title', 'Add to Wishlist');

				});
			});
		}
		
	};

})(jQuery);