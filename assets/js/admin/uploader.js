jQuery(document).ready(function($) {
	// the upload image button, saves the id and outputs a preview of the image
	var imageFrame;

	$('.metabox-image').on( 'click', '.bearded-meta-upload', function( event ) {

		event.preventDefault();

		var options, attachment;
		
		$self = $(this);

		sel_id = $self.data('id');
		
		// if the frame already exists, open it
		if ( imageFrame ) {
			imageFrame.open();
			return;
		}
		
		// set our settings
		imageFrame = wp.media({
			title: 'Choose Image',
			multiple: false,
			library: {
		 		type: 'image'
			},
			button: {
		  		text: 'Use This Image'
			}
		});
		
		// set up our select handler
		imageFrame.on( 'select', function() {
			selection = imageFrame.state().get('selection');
			
			if ( ! selection )
			return;
			
			// loop through the selected files
			selection.each( function( attachment ) {
				var src = attachment.attributes.sizes.thumbnail.url;
				var id = attachment.id;
				
				$('#' + sel_id + '-preview img').attr('src', src);
				$('#' + sel_id ).val(id);
			} );
		});
		
		// open the frame
		imageFrame.open();
	});

	$('.metabox-image').on('click', '.bearded-remove-image', function(event) {
		var id = $(this).data('id');
		$('#' + id).val('');
		$('#' + id + '-preview img').attr('src', '');
		event.preventDefault();

	});
	
});