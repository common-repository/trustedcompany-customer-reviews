<?php
/*
Plugin Name: TrustedCompany Customer Reviews for WooCommerce
Depends: WooCommerce
Plugin URI: https://github.com/AdelBachene/WooCommerce-Trustcompany
Description: Send the TrustedCompany BCC email after order processing
Version: 1.0.0
Author: Adel Bachene
License: GPLv2
*/

/*  Copyright @TrsutedCompany.com Tech Team (tech@trustedcompany.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Check if WooCommerce is active
 **/
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{
// Put your plugin code here
//die('install Woocommerce First');
}

if(!class_exists('WooCommerce_TrustedCompany')) 
{ 
	
class WooCommerce_TrustedCompany 
{ 
/*
* Construct the plugin object 
*/ 
public function __construct() 
{ 
	load_plugin_textdomain( 'woocommerceTrustedCompany', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
 	// register actions 
	add_action('admin_init', array(&$this, 'admin_init')); 
	add_action('admin_menu', array(&$this, 'add_menu')); 
	
	
	
	add_filter( 'init', array( $this, 'init' ) );
} 
// END public 

/** 
 * Activate the plugin 
**/ 
public static function activate() 
{ 
	// Do nothing 
} 
// END public static function activate 

/** 
 * Deactivate the plugin 
 * 
**/ 
public static function deactivate() 

{ // Do nothing 
} 
// END public static function deactivate 

/** 
 * hook into WP's admin_init action hook 
 * */ 
 
public function admin_init() 
{ 
	// Set up the settings for this plugin 
	
	$this->init_settings(); 
	// Possibly do additional admin_init tasks 
} 
// END public static function activate - See more at: http://www.yaconiello.com/blog/how-to-write-wordpress-plugin/#sthash.mhyfhl3r.JacOJxrL.dpuf

/** * Initialize some custom settings */ 
public function init_settings() 
{ 
	// register the settings for this plugin 
	register_setting('woocommerce-trustcompany', 'trustedCompanyEmail'); 
	register_setting('woocommerce-trustcompany', 'sendwhen'); 
} // END public function init_custom_settings()


/** * add a menu */ 
public function add_menu() 
{
	 
	 add_options_page('WooCommerce TrustedCompany Settings', 'WooCommerce TrustedCompany', 'manage_options', 'woocommerce--trustedcompany', array(&$this, 'woocommerceTrustedCompany_settings_page'));
} // END public function add_menu() 

/** * Menu Callback */ 
public function woocommerceTrustedCompany_settings_page() 
{ 
	if(!current_user_can('manage_options')) 
	{ 
		wp_die(__('You do not have sufficient permissions to access this page.')); 
	
	} 
// Render the settings template 

include(sprintf("%s/templates/settings.php", dirname(__FILE__))); 

} 
// END public function plugin_settings_page() 

	



function init()
{


	add_filter( 'woocommerce_email_headers', 'mycustom_headers_filter_function', 10, 3);

	function mycustom_headers_filter_function( $headers, $id, $object ) {
		if ($id == 'customer_completed_order' && get_option('sendwhen','complete')==='complete') {
			$headers .= 'BCC: '.get_option('trustedCompanyEmail'). "\r\n";
		}
        if ($id == 'customer_processing_order' && get_option('sendwhen','complete')==='process') {
			
			$headers .= 'BCC: '.get_option('trustedCompanyEmail'). "\r\n";
		}
		return $headers;
	}
	
	if(get_option('sendwhen','complete')==='complete')
	{
	add_filter( 'woocommerce_email_subject_customer_completed_order', 'trustedcompany_email_subject_customer_completed_order',10, 2 );
	function trustedcompany_email_subject_customer_completed_order($subject,$object){
		return $subject.' ('.__('Order ','woocommerceTrustedCompany').' '.(string)$object->get_order_number().')';
	}
	}
	
	if(get_option('sendwhen','complete')==='process')
	{
	add_filter( 'woocommerce_email_subject_customer_processing_order', 'trustedcompany_email_subject_customer_processing_order',10, 2 );
	function trustedcompany_email_subject_customer_processing_order($subject,$object){
		return $subject.' ('.__('Order ','woocommerceTrustedCompany').' '.(string)$object->get_order_number().')';
	}
	}
}



} // END class 

}

if(class_exists('WooCommerce_TrustedCompany')) 
{ // Installation and uninstallation hooks 
	register_activation_hook(__FILE__, array('WooCommerce_TrustedCompany', 'activate')); 
	register_deactivation_hook(__FILE__, array('WooCommerce_TrustedCompany', 'deactivate')); 
	
	$woocommerceTrustedCompany = new WooCommerce_TrustedCompany();
	// Add a link to the settings page onto the plugin page 
	if(isset($woocommerceTrustedCompany))
	{
		
		 function woocommerceTrustedCompany_settings_link($links) 
		 { 
			 $settings_link = '<a href="options-general.php?page=woocommerce--trustedcompany">'.__('Settings','woocommerceTrustedCompany').'</a>';
			 array_unshift($links, $settings_link); 
			
			 return $links; 
		 } 	
		 $plugin = plugin_basename(__FILE__); 
		 	
		
		 add_filter("plugin_action_links_$plugin", 'woocommerceTrustedCompany_settings_link'); 
	}
	
}
