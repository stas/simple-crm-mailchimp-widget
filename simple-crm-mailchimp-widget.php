<?php
/*
Plugin Name: Simple CRM MailChimp Widget Addon
Plugin URI: http://wordpress.org/extend/plugins/simple-crm-mailchimp-widget/
Description: Add MailChimp Subscribe Widget to Simple CRM
Author: Stas Sușcov
Version: 0.1
Author URI: http://stas.nerd.ro/
*/

define( 'SCRM_MC_WG_ROOT', dirname( __FILE__ ) );
define( 'SCRM_MC_WG_WEB_ROOT', WP_PLUGIN_URL . '/' . basename( SCRM_MC_WG_ROOT ) );

require_once SCRM_MC_WG_ROOT . '/includes/mc_wg.class.php';

/**
 * i18n
 */
function scrm_mc_wg_textdomain() {
    load_plugin_textdomain( 'scrm_mc_wg', false, basename( SCRM_MC_WG_ROOT ) . '/languages' );
}
add_action( 'init', 'scrm_mc_wg_textdomain' );

MC_WG::init();

?>
