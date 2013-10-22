jQuery(document).ready(function($){
	
	$('body').on('click', '.bearded-choose-icon', function(event) {


		var id = $(this).attr('id').replace('icon-action-', '');


		var modal = '<div id="bearded-icon-modal-overlay"></div><div id="bearded-icon-modal"><div id="bearded-modal-loader"></div></div>';

		$('body').append(modal);

		var modal_sel = $('#bearded-icon-modal');
		var overlay_sel = $('#bearded-icon-modal-overlay');
		var windowWidth = $(window).outerWidth();
        var windowHeight = $(window).outerHeight();

        modal_sel.css({
            'width': windowWidth,
            'height': windowHeight,
            'position': 'fixed',
            'z-index': '999',
            'top': '10%',
            'left': '0',
            'overflow-y': 'auto'
        });
        overlay_sel.css({
            'opacity': 0.7,
            'height': windowHeight,
            'width': windowWidth,
            'position': 'fixed',
            'left': '0px',
            'top': '0px',
            'z-index': '995'
        });

		
		
		var nonce_field = $(this).next('input[type="hidden"]').val();
		$.post(bearded_ajax.url, {
            action: 'icon_selection',
            nonce: nonce_field,
            item_id: id
        }, function (data) {
            var content = $(data);
            
            modal_sel.find('#bearded-modal-loader').remove().end().append($(data));
        });


		event.preventDefault();
	});
	$('body').on('click', '#bearded-icon-modal .close-popup', function(event) {

		$('#bearded-icon-modal, #bearded-icon-modal-overlay').hide().remove();
		event.preventDefault();
		/* Act on the event */
	});

	$('body').on('click', '#bearded-icon-modal .cell', function(event) {

		$(this).addClass('active').siblings().removeClass('active');
		event.preventDefault();
		/* Act on the event */
	});

	$('body').on('click', '#bearded-icon-modal button.select-icon', function(event) {

		var id = $(this).attr('id').replace('font-icon-', '');

		var selected_icon = $('#bearded-icon-modal').find('.cell.active i').attr('class');

		$('#edit-menu-item-icon-'+id).val(selected_icon);

		$('#bearded-icon-modal, #bearded-icon-modal-overlay').hide().remove();

		event.preventDefault();
		/* Act on the event */
	});

	$('.remove-font-icon').click(function(event){

		var id = $(this).attr('id').replace('remove-icon-', '');
		$('#edit-menu-item-icon-' +id ).val('');

		event.preventDefault();
	});
});