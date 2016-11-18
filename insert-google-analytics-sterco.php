<?php
/*
* Plugin Name: Insert Google Analytics by Sterco Digitex
* Plugin URI: http://stercodigitex.com
* Author: Krishna Kant Gupta
* Author URI: https://www.paypal.me/KrishnaGupta
* Description: The Google Analytics wordpress plugin enable google analytics to all pages. Allow to find out how your visitors locate your website. Able to identify which pages and links your visitors click the most. Able to fine tune your website.
* Version: 1.0.0

* @package WordPress
* @subpackage DOT_CFI
* @author Krishna
* License:
  Copyright 2016 "Wordpress Google Analytics by Stercoc Digitex" (sterco.krishna@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 1, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY.
*/
?>
<?php
if(!defined('ABSPATH')) exit;

// Add plugin menu in main admin menu
add_action('admin_menu','wps_google_analytic_menu');

// Register style sheet.
add_action('admin_enqueue_scripts','register_wps_google_styles');

class wps_google_analytic{
	public function __construct(){
		$positionValue = get_option('wps_google_analytic_position');
		
		if($positionValue == 'header'){
			add_action('wp_head','wps_google_analytic_header');
		}
		else{
			add_action('wp_footer','wps_google_analytic_footer');
		}
	}
}

function register_wps_google_styles(){
	wp_register_style('wps_google_style', plugin_dir_url( __FILE__ ) . 'css/analytic.css');
	wp_enqueue_style('wps_google_style');
}

function wps_google_analytic_header(){
	echo $code = get_option('wps_google_analytic_code');
}

function wps_google_analytic_footer(){
	echo $code = get_option('wps_google_analytic_code');
}


function wps_google_analytic_menu(){
	add_menu_page(
					'Wordpress Google Analytics', 	// Page title
					'Wordpress Google Analytics',	// Menu title
					'administrator',				// Capability
					'wps-google-analytic',			// Slug name
					'wps_google_analytic_page',		// Callback function name
					'dashicons-screenoptions',		// Menu icon class (class or link)
					'90'							// Position of menu (int)
				);
}

// Register form fields
function wps_google_analytic_fields(){
	register_setting('wps_google_analytic_group','wps_google_analytic_code');
	register_setting('wps_google_analytic_group','wps_google_analytic_position');
}

add_action('admin_init','wps_google_analytic_fields');

function wps_google_analytic_page(){ ?>
	<div class="wrap">
		<div class="title">
			<h1>Wordpress Google Analytics</h1>
		</div>
	</div>
	<div class="wrap">
		<form action="options.php" method="post">
			<?php 
				settings_fields('wps_google_analytic_group'); 
				do_settings_sections('wps_google_analytic_group');
			?>
			<div class="row">
				<div class="wps_left"><label class="wps_label">Insert analytic code</label></div>
				<textarea name="wps_google_analytic_code" rows="10" cols="85"><?php echo get_option('wps_google_analytic_code'); ?></textarea>
			</div>
			<div class="row">
				<div class="wps_left"><label class="wps_label">Analytic position</label></div>
				<select name="wps_google_analytic_position">
					<option value="header">Header</option>
					<option value="footer" <?php echo wps_get_selected_value(); ?>>Footer</option>
				</select>
			</div>
			<?php submit_button(); ?>
		</form>
		<div class="wps-donate">
			<p><a href="https://www.paypal.me/KrishnaGupta" target="_blank">Donate</a> to this plugin.</p>
		</div>
	</div>
<?php }

function wps_get_selected_value(){
$select = get_option('wps_google_analytic_position');
	if($select == 'footer'){
		return $value = 'selected';
	}	
}

$wps_google = new wps_google_analytic();