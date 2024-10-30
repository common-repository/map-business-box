jQuery(document).ready(function($){
    $('.my-color-field').wpColorPicker();
	
	$('.header_logo_upload').click(function(e) {
		var location_number = $(this).data("lno");
		e.preventDefault();

		var custom_uploader = wp.media({
			title: 'Custom Image',
			button: {
				text: 'Upload Image'
			},
			multiple: false  // Set this to true to allow multiple files to be selected
		})
		.on('select', function() {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			$('.header_logo_'+location_number).attr('src', attachment.url);
			$('#location_logo_'+location_number).val(attachment.url);

		})
		.open();
	});
});

