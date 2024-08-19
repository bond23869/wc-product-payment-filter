<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://1.com
 * @since             1.0.0
 * @package           Product_Payment_Filter
 *
 * @wordpress-plugin
 * Plugin Name:       Product Payment Filter
 * Plugin URI:        https://1.com
 * Description:       This plugin enables the user to select products and payment methods which not to show if the product is in the cart.
 * Version:           1.0.0
 * Author:            Jan Kotnik
 * Author URI:        https://1.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       product-payment-filter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRODUCT_PAYMENT_FILTER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-product-payment-filter-activator.php
 */
function activate_product_payment_filter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-payment-filter-activator.php';
	Product_Payment_Filter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-product-payment-filter-deactivator.php
 */
function deactivate_product_payment_filter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-payment-filter-deactivator.php';
	Product_Payment_Filter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_product_payment_filter' );
register_deactivation_hook( __FILE__, 'deactivate_product_payment_filter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-product-payment-filter.php';

/**
 * Include the WC_Payment_Method_Filter class.
 */
require plugin_dir_path( __FILE__ ) . 'class-product-payment-filter.php';


require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-payment-filter-api.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_product_payment_filter() {
	$plugin = new Product_Payment_Filter();
	$plugin->run();

	// Initialize the WC_Payment_Method_Filter class
	new WC_Payment_Method_Filter();
	new WC_Payment_Gateway_Filter_API();
}
run_product_payment_filter();