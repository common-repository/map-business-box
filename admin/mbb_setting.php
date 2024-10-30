<?php ob_start();
	if ( ! defined( 'ABSPATH' ) ) exit; 
	
	if (!current_user_can('administrator')) {
		echo nl2br("\n");
		echo "Please use administrator account for access this page.";
		exit;
	}
	
	if (isset($_REQUEST['submit']) && isset($_REQUEST['_wpnonce']) && !empty($_REQUEST['_wpnonce'])) {
		$no_of_location = get_option( 'mbb_no_of_location', false );
		
		for ($ln = 1;$ln<=$no_of_location;$ln++) {
			delete_option( 'mbb_location_title_'.$ln ); 	 	
			delete_option( 'mbb_location_phone_'.$ln ); 	 	
			delete_option( 'mbb_location_email_'.$ln ); 	 	
			delete_option( 'mbb_location_address_'.$ln ); 	 	
			delete_option( 'mbb_location_logo_'.$ln ); 	 	
			delete_option( 'mbb_location_map_'.$ln ); 	 	
		}
		
		$no_of_location = $_REQUEST['no_of_location'];
		update_option( 'mbb_no_of_location', sanitize_text_field($_REQUEST['no_of_location'] ));
		update_option( 'mbb_bar_color', sanitize_text_field($_REQUEST['bar_color'] ));
		update_option( 'mbb_text_color', sanitize_text_field($_REQUEST['text_color'] ));
		update_option( 'mbb_text_highlight_color', sanitize_text_field($_REQUEST['text_highlight_color'] ));
		
		$k = 1;
		for ($j=1;$j<=$no_of_location;$j++) {
			if ($_REQUEST['location_title_'.$j]) {
				update_option( 'mbb_location_title_'.$k, sanitize_text_field($_REQUEST['location_title_'.$j] ));
				update_option( 'mbb_location_phone_'.$k, sanitize_text_field($_REQUEST['location_phone_'.$j] ));
				update_option( 'mbb_location_email_'.$k, sanitize_text_field($_REQUEST['location_email_'.$j] ));
				update_option( 'mbb_location_address_'.$k, sanitize_textarea_field($_REQUEST['location_address_'.$j] ));
				update_option( 'mbb_location_logo_'.$k, sanitize_text_field($_REQUEST['location_logo_'.$j] ));
				update_option( 'mbb_location_map_'.$k, sanitize_textarea_field(htmlentities($_REQUEST['location_map_'.$j])));
				$k++;
			}
		}
	}
	
	$no_of_location = 0;
	
	$no_of_location = get_option( 'mbb_no_of_location', false );
	$bar_color = get_option( 'mbb_bar_color', false );
	$text_color = get_option( 'mbb_text_color', false );
	$text_highlight_color = get_option( 'mbb_text_highlight_color', false );
	
	if (!$bar_color) {
		$bar_color = '#262F3E';
	}
	
	if (!$text_color) {
		$text_color = '#fff';
	}
	
	if (!$text_highlight_color) {
		$text_highlight_color = '#8ECA00';
	}
?>

<style>
.wp-picker-holder {
	position: absolute;
    z-index: 999999;
}

.mbb_h1_cls {
    color: #0073aa;
}

.mbb_h3_cls {
	border-bottom: 1px solid #0073aa;
    color: #0073aa;
    padding-bottom: 10px;
}
</style>
<h1 class="mbb_h1_cls">Map Business Box Setting</h1>

<p>For use this plugin put shortcode <b>[mbb_shortcode]</b>. </p>

<form id="mbb_form_id" action="<?php echo admin_url( 'admin.php' ); ?>?page=mbb-plugin" method="POST">
	<div class="form-group">
		<label for="no_of_location">No Of Location <button type="button" class="btn btn-default update_no_location" >Update</button></label>
		<input type="text" class="form-control" name="no_of_location" value="<?php echo $no_of_location;?>" placeholder="Enter no of locations">
	</div>
	<hr style="width:100%; color:#666;">
	<h3 class="mbb_h3_cls">Choose Colors for Bar</h3>
  
	<div class="form-group">
		<label style="width:150px" for="bar_color">Bar Color</label>
		<input type="text" name="bar_color" value="<?php echo $bar_color;?>" class="my-color-field" data-default-color="#262F3E" />
	</div>
	
	<div class="form-group">
		<label style="width:150px" for="text_color">Text Color</label>
		<input type="text" name="text_color" value="<?php echo $text_color;?>" class="my-color-field" data-default-color="#fff" />
	</div>
	
	<div class="form-group">
		<label style="width:150px" for="text_highlight_color">Text Highlight Color</label>
		<input type="text" name="text_highlight_color" value="<?php echo $text_highlight_color;?>" class="my-color-field" data-default-color="#fff" />
	</div>
	
	<hr style="width:100%; color:#666;">
	<h3 class="mbb_h3_cls">Location Details</h3>
	
	<?php for($l=1;$l<=$no_of_location;$l++) { ?>
		<h4>Location <?php echo $l;?>  <button type="button" class="btn btn-default delete_location" data-lno="<?php echo $l;?>">Delete</button></h4>
		<div class="form-group">
			<label for="location_title_<?php echo $l;?>">Title</label>
			<input type="text" class="form-control" id="location_title_<?php echo $l;?>" name="location_title_<?php echo $l;?>" value="<?php echo get_option( 'mbb_location_title_'.$l, false ); ?>" placeholder="Enter Title">
			
		</div>
		<div class="form-group">
			<label for="location_phone_<?php echo $l;?>">Phone No</label>
			<input type="text" class="form-control" id="location_phone_<?php echo $l;?>" name="location_phone_<?php echo $l;?>" value="<?php echo get_option( 'mbb_location_phone_'.$l, false ); ?>" placeholder="Enter Phone Number">
		</div>
		<div class="form-group">
			<label for="location_email_<?php echo $l;?>">Email address</label>
			<input type="email" id="location_email_<?php echo $l;?>" name="location_email_<?php echo $l;?>" value="<?php echo get_option( 'mbb_location_email_'.$l, false ); ?>" class="form-control" placeholder="Enter email">
		</div>
		<div class="form-group">
			<label for="location_address_<?php echo $l;?>">Address</label>
			<textarea class="form-control" id="location_address_<?php echo $l;?>" name="location_address_<?php echo $l;?>"><?php echo esc_textarea( get_option( 'mbb_location_address_'.$l, false ) ); ?></textarea>	
		</div>
		<div class="form-group">
			<label style="width:100%" for="location_logo_<?php echo $l;?>">Logo</label>
			<img class="header_logo_<?php echo $l;?>" src="<?php echo esc_url(get_option( 'mbb_location_logo_'.$l, false )); ?>" height="100" width="100"/>
			<input type="text" id="location_logo_<?php echo $l;?>" name="location_logo_<?php echo $l;?>" value="<?php echo get_option( 'mbb_location_logo_'.$l, false ); ?>" class="regular-text">
			<input type="button" name="upload-btn" class="btn btn-default header_logo_upload" data-lno="<?php echo $l;?>" value="Upload Logo">
		</div>
		<div class="form-group">
			<label for="location_map_<?php echo $l;?>">Map Embedded Code</label>
			<textarea class="form-control" id="location_map_<?php echo $l;?>" name="location_map_<?php echo $l;?>"> <?php 
				$embedd_map = get_option( 'mbb_location_map_'.$l, false );
				$embedd_map = str_replace('\\', "", $embedd_map);
				echo $embedd_map; 
			?></textarea>	
			<p class="help-block"><strong>For create Map Embedded Code, Please </strong><a href="//support.google.com/maps/answer/144361?co=GENIE.Platform%3DDesktop&hl=en&oco=1" target="_blank">Click this link</a></p>
		</div>
		<hr style="width:100%; color:#666;">
	<?php } ?>	
	<input type="hidden" id="_wpnonce" name="_wpnonce" value="344911a67c">
  <button type="submit" name="submit" class="btn btn-primary smt_btn">Submit</button>
</form>

<script>
jQuery(document).on('click', '.update_no_location', function() {
	jQuery(".smt_btn").click();
})

jQuery(document).on('click', '.delete_location', function() {
	var lno = jQuery(this).data("lno");
	jQuery("#location_title_"+lno).val("");
	jQuery("#location_phone_"+lno).val("");
	jQuery("#location_email_"+lno).val("");
	jQuery("#location_address_"+lno).val("");
	jQuery("#location_logo_"+lno).val("");
	jQuery("#location_map_"+lno).val("");
	jQuery(".smt_btn").click(); 
})
</script>