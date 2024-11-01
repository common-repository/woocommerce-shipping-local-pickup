<?php
/*
Plugin Name: WooCommerce Local Pickup Shipping Method
Plugin URI: http://www.garmantech.com/wordpress-plugins/woocommerce-extensions/local-pickup-shipping-method/
Description: Extends WooCommerce with a local pickup shipping method.
Version: 1.0.1
Author: Garman Technical Services
Author URI: http://www.garmantech.com/wordpress-plugins/
License: GPLv2
*/

/*  Copyright 2011  Garman Technical Services  (email : contact@garmantech.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('plugins_loaded', 'woocommerce_local_pickup_shipping_init', 0);

function woocommerce_local_pickup_shipping_init() {
	if (!class_exists('woocommerce_shipping_method')) return;
		class local_pickup extends woocommerce_shipping_method {

			function __construct() { 
				$this->id 			= 'local_pickup';
				$this->method_title = __('Local Pickup', 'woothemes');
				$this->enabled		= get_option('woocommerce_local_pickup_enabled');
				$this->title 		= get_option('woocommerce_local_pickup_title');
				add_action('woocommerce_update_options_shipping_methods', array(&$this, 'process_admin_options'));
				add_option('woocommerce_local_pickup_availability', 'all');
				add_option('woocommerce_local_pickup_title', 'Local Pickup');
			} 
		    
			function calculate_shipping() {
				$this->shipping_total 	= 0;
				$this->shipping_tax 	= 0;
				$this->shipping_label 	= $this->title;	    	
			}
		    
			function admin_options() {
				global $woocommerce;
				?>
				<h3><?php _e('Local Pickup', 'woothemes'); ?></h3>
				<div style="position:fixed; top:25%; right:5px;"><a href="#" onClick="script: Zenbox.show(); return false;"><img src="https://apps.garmantech.com/files/support_right.png" /></a></div>
				<table class="form-table">
					<tr valign="top">
						<th scope="row" class="titledesc"><?php _e('Enable/disable', 'woothemes') ?></th>
						<td class="forminp">
							<fieldset>
								<legend class="screen-reader-text"><span><?php _e('Enable/disable', 'woothemes') ?></span></legend>
								<label for="woocommerce_local_pickup_enabled>">
								<input name="woocommerce_local_pickup_enabled" id="woocommerce_local_pickup_enabled" type="checkbox" value="1" <?php checked(get_option('woocommerce_local_pickup_enabled'), 'yes'); ?> /> <?php _e('Enable Local Pickup', 'woothemes') ?></label><br>
							</fieldset>
						</td>
					    </tr>
					    <tr valign="top">
						<th scope="row" class="titledesc"><?php _e('Method Title', 'woothemes') ?></th>
						<td class="forminp">
							<input type="text" name="woocommerce_local_pickup_title" id="woocommerce_local_pickup_title" style="min-width:50px;" value="<?php if ($value = get_option('woocommerce_local_pickup_title')) echo $value; else echo 'Local Pickup'; ?>" /> <span class="description"><?php _e('This controls the title which the user sees during checkout.', 'woothemes') ?></span>
						</td>
					    </tr>
				</table>
				<script type="text/javascript" src="//asset0.zendesk.com/external/zenbox/v2.3/zenbox.js"></script>
				<style type="text/css" media="screen, projection">
				  @import url(//asset0.zendesk.com/external/zenbox/v2.3/zenbox.css);
				</style>
				<script type="text/javascript">
				  if (typeof(Zenbox) !== "undefined") {
				    Zenbox.init({
				      dropboxID:	"20029372",
				      url:		"https://garmantech.zendesk.com",
				      tabID:		"support",
				      tabColor:	"black",
				      tabPosition:	"Right",
				      hide_tab:	true,
				    });
				  }
				</script>
				<?php
			}

			function process_admin_options() {
		   		if(isset($_POST['woocommerce_local_pickup_enabled'])) update_option('woocommerce_local_pickup_enabled', 'yes'); else update_option('woocommerce_local_pickup_enabled', 'no');
		   		if(isset($_POST['woocommerce_local_pickup_title'])) update_option('woocommerce_local_pickup_title', woocommerce_clean($_POST['woocommerce_local_pickup_title'])); else delete_option('woocommerce_local_pickup_title');
			}

		}

	function add_local_pickup_method( $methods ) {
		$methods[] = 'local_pickup'; return $methods;
	}

	add_filter('woocommerce_shipping_methods', 'add_local_pickup_method' );

}