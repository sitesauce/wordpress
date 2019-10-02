<?php

namespace Sitesauce\Wordpress;

use Sitesauce\Wordpress\UI\SettingsScreen;
use Sitesauce\Wordpress\WebhookTrigger;
use Sitesauce\Wordpress\Settings;

final class App
{
    /**
     * Singleton instance
     * 
     * @var null|App
     */
    private static $instance = null;

    /**
     * Create a new singleton instance
     * 
     * @return App
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
        	self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Bootstrap the plugin
     * 
     * @return void
     */
    private function __construct()
    {
        $this->constants();
        $this->includes();
        $this->hooks();
    }

    /**
     * Register constants
     *
     * @return void
     */
    protected function constants()
    {
        define('SITESAUCE_DEPLOYMENTS_OPTIONS_KEY', 'wp_sitesauce_deployments');
    }

    /**
     * Include/require files
     *
     * @return void
     */
    protected function includes()
    {
        require_once (SITESAUCE_DEPLOYMENTS_PATH.'/src/UI/SettingsScreen.php');

        require_once (SITESAUCE_DEPLOYMENTS_PATH.'/src/Settings.php');
        require_once (SITESAUCE_DEPLOYMENTS_PATH.'/src/WebhookTrigger.php');
        require_once (SITESAUCE_DEPLOYMENTS_PATH.'/src/Field.php');

        require_once (SITESAUCE_DEPLOYMENTS_PATH.'/src/functions.php');
    }

    /**
     * Register actions & filters
     *
     * @return void
     */
    protected function hooks()
    {
        SettingsScreen::init();
        Settings::init();
    }

    /**
     * Fires on plugin activation
     *
     * @return void
     */
    public function activation()
    {
        
    }

    /**
     * Fires on plugin deactivation
     *
     * @return void
     */
    public function deactivation()
    {

    }
}
