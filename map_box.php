<?php
/*
Plugin Name: Map Business Box 
Plugin URI: http://localmap.co
Description: Make your business representable using map.
Version: 1.0
Author: Local Map Co.
Author URI: http://localmap.co
License:  
*/
if ( ! defined( 'ABSPATH' ) ) exit; 
	/* Set the constants needed by the plugin. */
	add_action( 'plugins_loaded', 'mbb_constants', 1 );
	
	/**
	 * Defines constants used by the plugin.
	 *
	*/
	function mbb_constants(){
		
		/* Set constant path to the Store Locator plugin directory. */
		define( 'MBB_DIR', trailingslashit(plugin_dir_path( __FILE__ )));

		/* Set constant path to the Store Locator plugin URL. */
		define( 'MBB_URL', trailingslashit(plugin_dir_url( __FILE__ )));

		/* Set the constant path to the Store Locator admin directory. */
		define( 'MBB_ADMIN', MBB_DIR . trailingslashit( 'admin' ) );
		
		/* Set the constant path to the Store Locator stylesheet directory. */
		define( 'MBB_ASSETS', MBB_URL . trailingslashit( 'assets' ));
		
		/* Set the constant path to the Store Locator stylesheet directory. */
		define( 'MBB_FRONT', MBB_DIR . trailingslashit( 'front-end' ));
			
	}
	
	
	
	// Add menu on admin section
	add_action('admin_menu', 'mbb_plugin_setup_menu');
	 
	function mbb_plugin_setup_menu(){
		add_menu_page( 'Map Business Box', 'MBB Plugin', 'manage_options', 'mbb-plugin', 'mbb_admin_section' );
	}
	 
	function mbb_admin_section(){
		require_once( MBB_ADMIN . 'mbb_setting.php');
	}

	/**
	 *  Enqueue stylesheet for admin
	 *
	**/
	function mbb_admin_style() {
		// Deregister the included library
		//wp_deregister_script( 'jquery' );
		 
		// Register the library again from Google's CDN
		wp_enqueue_script( 'jquery');
		 
		// Bootstrap JS
		wp_register_script('mbb_bootstrap', MBB_ASSETS.'bootstrap.min.js');
		wp_enqueue_script('mbb_bootstrap');

		// Bootstrap CSS
		wp_register_style('mbb_bootstrap', MBB_ASSETS.'bootstrap.min.css');
		wp_enqueue_style('mbb_bootstrap');
		
		// For Wp Color Picker....
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'my-script-handle', MBB_ASSETS.'my-script.js', array( 'wp-color-picker' ), false, true );
		
		wp_enqueue_media();
	}
	
	/* Add style for admin */
	add_action( 'admin_enqueue_scripts', 'mbb_admin_style');
	
	/**
	 *  Enqueue stylesheet For Front End
	 *
	**/
	function mbb_front_style() {
		
	}
	
	/* Add style for front-end */
	add_action( 'wp_enqueue_scripts', 'mbb_front_style');
	
	
	function form_creation(){
	ob_start();
	
	$no_of_location = get_option( 'mbb_no_of_location', false );
	$bar_color = get_option( 'mbb_bar_color', false );
	$text_color = get_option( 'mbb_text_color', false );
	$text_highlight_color = get_option( 'mbb_text_highlight_color', false );
	
	?>
	<style>
		.mbb-contact-map-wrapp {
			background: <?php echo $bar_color;?> none repeat scroll 0 0;
			display: inline-block;
			margin-top: -3px;
			position: relative;
			width: 100%;
		}
		.mbb-map-tab-wrapper {
			background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
			margin-bottom: -3px;
			margin-top: 0;
			padding-top: 3px;
		}
		.mbb_tab .nav-tabs > li > a {
			border: medium none;
			border-radius: 0;
			color: <?php echo $text_color;?>;
			font-family: "Roboto",sans-serif;
			font-size: 14px;
			font-weight: 700;
			height: 60px;
			line-height: 50px;
			margin: 0;
			padding: 18px 10px;
			position: relative;
			text-align: center;
			width: 155px;
		}
		.mbb_tab .nav-tabs > li > a::after {
			border-left: 10px solid transparent;
			border-right: 10px solid transparent;
			border-top: 10px solid <?php echo $text_highlight_color;?>;
			bottom: -9px;
			content: "";
			display: none;
			height: 0;
			left: 50%;
			margin-left: -5px;
			position: absolute;
			width: 0;
			z-index: 10;
		}
		.mbb-contact-map-wrapp .nav-tabs > li {
			margin-bottom: 0;
			display:inline;
		}
		.mbb_tab .nav-tabs {
			border-bottom: 0 none;
			display: table;
			margin: -3px auto 0;
		}
		
		.mbb_tab .nav-tabs > li.active > a, .mbb_tab .nav-tabs > li.active > a:hover, .mbb_tab .nav-tabs > li.active > a:focus, .mbb_tab .nav-tabs > li:hover > a {
			background-color: <?php echo $text_highlight_color;?>;
			border: medium none;
			border-radius: 0;
			color: <?php echo $text_color;?>;
			cursor: default;
		}
		.mbb_tab .nav-tabs > li.active > a::after, .mbb_tab .nav-tabs > li.active > a:hover::after, .mbb_tab .nav-tabs > li.active > a:focus::after, .mbb_tab .nav-tabs > li:hover > a::after {
			display: block;
		}
		.mbb-contact-map-wrapp .nav-tabs > li > a::before {
			border-bottom: medium none;
			border-left: 10px solid transparent;
			border-right: 10px solid transparent;
			border-top: 10px solid <?php echo $text_highlight_color;?>;
			content: "";
			display: none;
			height: 0;
			left: 50%;
			margin-left: -5px;
			position: absolute;
			top: 100%;
			width: 0;
			z-index: 10;
		}
		.mbb-map-wrap {
			position: relative;
		}
		.mbb-map-overlay {
			min-height: 470px;
			position: absolute;
			top: 0;
			width: 100%;
			z-index: 10;
		}
		.mbb-home-map-wrapp .tab-content .mbb_container {
			left: 0;
			position: absolute;
			right: 0;
			top: 60px;
			z-index: 10;
		}
		.mbb_container {
			margin:0 auto;
			max-width:1200px;
			width:100%;
		}
		.mbb_map_address {
			background: #fefefe none repeat scroll 0 0;
			box-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
			display: table;
			float: right;
			padding: 25px 23px 28px;
			text-align: center;
			width: auto;
		}
		.mbb_map_address_image {
			display: table;
			height: auto;
			margin: 0 auto 18px;
			text-align: center;
			width: auto;
		}
		.mbb_map_address strong {
			border-bottom: 1px solid #eeeeee;
			border-top: 1px solid #eeeeee;
			color: #333333;
			display: block;
			font-size: 30px;
			font-weight: bold;
			margin: 0 0 11px;
			padding: 12px 0 15px;
			text-align: center;
		}
		.mbb_map_address strong a, .mbb_map_address strong a:hover, .mbb_map_address strong a:focus {
			color: #333333;
		}
		.mbb_map_address span {
			color: #8eca00;
			display: block;
			font-size: 18px;
			font-weight: 300;
			text-align: center;
		}
		.mbb_map_address span a, .mbb_map_address span a:hover, .mbb_map_address span a:focus {
			color: #8eca00;
		}
		.mbb_map_address p {
			border-top: 1px solid #eeeeee;
			color: #666666;
			display: block;
			font-size: 18px;
			font-weight: 300;
			line-height: 26px;
			margin: 12px 0 0;
			padding: 16px 0 0;
			text-align: center;
		}
		
		.mbb_hide { display:none;}
		.mbb_tab_cls {cursor:pointer;}
		.mbb-map-wrap iframe {width:100%;}
		
		@media only screen and (max-width:768px) {
			.mbb-contact-map-wrapp .nav-tabs > li {
				display: inline-block;
				width:100%
			}
			.mbb_tab .nav-tabs > li > a, .mbb_tab .nav-tabs > li.active > a, .mbb_tab .nav-tabs > li.active > a:hover, .mbb_tab .nav-tabs > li.active > a:focus, .mbb_tab .nav-tabs > li:hover > a {
				width:100%;
				display: inline-block;
				padding:6px 10px;
			}
		}
	</style>
	<section class="mbb-contact-map-wrapp mbb-home-map-wrapp">
		<div class="mbb-map-tab-wrapper"> 
		<!-- Nav tabs -->
			<div class="mbb_tab">
				<ul class="nav nav-tabs" role="tablist">
					<?php for ($h=1;$h<=$no_of_location;$h++) { ?> 
						<li role="presentation" id="mbb_li_tab_<?php echo $h;?>" class="mbb_li_tab <?php if ($h==1) { echo "active"; } ?> ">
							<a class="mbb_tab_cls" data-mbb_tab_no="<?php echo $h;?>" id="button<?php echo $h;?>"><?php echo get_option( 'mbb_location_title_'.$h, false ); ?></a>
						</li>
					<?php } ?>
				</ul>
			</div>
			
			<div class="tab-content">
				<?php for ($k=1;$k<=$no_of_location;$k++) { ?>
					<div role="tabpanel" class="tab-pane<?php if ($k==1) { echo " active ";} else { echo " mbb_hide";} ?>" id="location_tab_<?php echo $k;?>">
						<div class="mbb-map-wrap">
							<div class="mbb-map-overlay" onclick="style.pointerEvents='none'"></div>
							<?php 
							$embedd_map = get_option( 'mbb_location_map_'.$k, false );
							$embedd_map = str_replace('\\', "", $embedd_map); 
							echo html_entity_decode($embedd_map);?>
							
							<div class="mbb_container">
								<div class="mbb_map_address"> 
									<div class="mbb_map_address_image">
										<img src="<?php echo esc_url(get_option( 'mbb_location_logo_'.$k, false )); ?>" alt="img">
									</div>
									<strong>
										<a href="tel:<?php echo get_option( 'mbb_location_phone_'.$k, false ); ?>"><?php echo get_option( 'mbb_location_phone_'.$k, false ); ?></a>
									</strong>
									<span>
										<a href="mailto:<?php echo get_option( 'mbb_location_email_'.$k, false ); ?>"><?php echo get_option( 'mbb_location_email_'.$k, false ); ?> </a>
									</span>
									<p><?php echo nl2br(get_option( 'mbb_location_address_'.$k, false )); ?></p>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>	
		</div>
	</section>	
	<script>
		jQuery(document).on('click', '.mbb_tab_cls', function() {
			var mbb_tab_number = jQuery(this).data('mbb_tab_no');
			jQuery('.mbb_li_tab').removeClass('active'); 
			jQuery('#mbb_li_tab_'+mbb_tab_number).addClass('active');  
			
			jQuery('.tab-pane').removeClass('active');
			jQuery('.tab-pane').removeClass('mbb_hide');
			jQuery('.tab-pane').addClass('mbb_hide');
			jQuery('#location_tab_'+mbb_tab_number).removeClass('mbb_hide');
			jQuery('#location_tab_'+mbb_tab_number).addClass('active');
		})
	</script>
	<?php
	$output = ob_get_clean();
     //print $output; // debug
     return $output;
	}
	add_shortcode('mbb_shortcode', 'form_creation');
	
	
?>
