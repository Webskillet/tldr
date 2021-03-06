jQuery(document).ready(function($) {
	$('#logo_url').hide();
	$('#logo_url_upload_button').show().click(function() {
		tb_show('Upload a logo', 'media-upload.php?referer=tldr-settings&type=image&TB_iframe=true&post_id=0', false);
		return false;
	});
	$('#logo_url_delete_button').click(function() {
		$('#logo_url').val('');
	});
});

window.send_to_editor = function(html) {
	var image_url = jQuery(html).attr('src');
	jQuery('#logo_url').val(image_url);
	tb_remove();
	if ( jQuery('#logo_url_preview img').length ) {
		jQuery('#logo_url_preview img').attr('src', image_url);
	} else {
		jQuery('#logo_url_preview').append('<img src="'+image_url+'" style="max-width: 100%;" />');
	}
	jQuery('#logo_url_preview').show();
	jQuery('#logo_url_upload_button').html('<span class="dashicons dashicons-upload"></span> Upload or choose another logo');
	jQuery('#logo_url_delete_button').show();
	jQuery('#options-form-submit').click();
}
