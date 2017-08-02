<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );
	
	/*
	* Plugin Name: Web To PrintQ - Product Designer
	* Plugin URI: http://en.web-to-printq.com/wp-designer/
	* Description: Plugin for integrating printQ Designer into WooCommerce
	* Author: CloudLab AG
	* Version: 1.2.6
	* Author URI: http://www.printq.eu
	* Requires at least: 4.4
	* Tested up to: 4.7.4
	*
	* @package printQ
	* @category WebToPrint
	* @author CloudLab AG
	*/

	define( 'PRINTQ_DESIGNER_VERSION', '1.2.6' );
	
	define( 'PRINTQ_ROOT', dirname( __FILE__ ) . DIRECTORY_SEPARATOR );
	
	define( 'PRINTQ_URL', plugin_dir_url( __FILE__ ) );
	
	require_once PRINTQ_ROOT . 'includes/config.php';
	
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		
		require_once PRINTQ_INCLUDES_DIR . 'printq_designer.php';
		
		$designer = new Printq_Designer();
		
		register_activation_hook( __FILE__, array( $designer, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $designer, 'deactivate' ) );
		
		$designer->run();
		
	}
