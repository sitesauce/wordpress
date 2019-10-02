<?php

/**
 * Plugin Name: Sitesauce
 * Description: Keep Sitesauce in sync with your Wordpress content.
 * Author: Miguel Piedrafita
 * Author URI: https://miguelpiedrafita.com
 * Plugin URI: https://sitesauce.app
 * Version: 0.2.3
 */

if (! defined('ABSPATH')) {
    exit;
}

define('SITESAUCE_DEPLOYMENTS_FILE', __FILE__);
define('SITESAUCE_DEPLOYMENTS_PATH', untrailingslashit(plugin_dir_path(__FILE__)));
define('SITESAUCE_DEPLOYMENTS_URL', untrailingslashit(plugin_dir_url(__FILE__)));

require_once(SITESAUCE_DEPLOYMENTS_PATH.'/src/App.php');

Sitesauce\Wordpress\App::instance();
