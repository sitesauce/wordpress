<?php

namespace Sitesauce\Wordpress\UI;

class SettingsScreen
{
    /**
     * Register the requred hooks for the admin screen
     *
     * @return void
     */
    public static function init()
    {
        add_action('admin_menu', [__CLASS__, 'addMenu']);
        add_filter('plugin_action_links_'.plugin_basename(SITESAUCE_DEPLOYMENTS_FILE), [__CLASS__, 'addSettingsLink']);
        add_filter('all_plugins', [__CLASS__, 'updatePluginDescription']);
        add_action('admin_notices', [__CLASS__, 'displayNotices']);
    }

    /**
     * Register an tools/management menu for the admin area
     *
     * @return void
     */
    public static function addMenu()
    {
        add_options_page(
            'Sitesauce Settings',
            'Sitesauce',
            'manage_options',
            'sitesauce',
            [__CLASS__, 'renderPage']
        );
    }

    /**
     * Add a link to the plugin settings page on the plugins page.
     *
     * @return void
     */
    public static function addSettingsLink($links)
    {
        array_unshift($links, '<a href="'.admin_url('options-general.php?page=sitesauce').'">'.__('Settings').'</a>');

        return $links;
    }

    /**
     * Update the plugin description when it's installed.
     *
     * @return void
     */
    public static function updatePluginDescription($all_plugins)
    {
		if (isset($all_plugins['sitesauce/sitesauce.php'])) {
			if (is_null(sitesauce_deployments_get_build_hook())) {
				$all_plugins['sitesauce/sitesauce.php']['Description'] = $all_plugins['sitesauce/sitesauce.php']['Description'].' To get started, configure a build hook on <a href="'.admin_url('options-general.php?page=sitesauce').'">the Sitesauce settings page</a>.';
			}
		}
		
		return $all_plugins;
    }

    /**
     * Display a configuration alert if the user hasn't configured the plugin yet.
     *
     * @return void
     */
    public static function displayNotices()
    {
        global $hook_suffix;

        if ($hook_suffix != 'settings_page_sitesauce' && is_null(sitesauce_deployments_get_build_hook())) {
            ?><div class="notice notice-warning">
                <p>To start using the Sitesauce integration, you'll need to add a build hook on <a href="/wp-admin/options-general.php?page=sitesauce">the settings page</a>.</p>
            </div><?php
        }
    }

    /**
     * Render the management/tools page
     *
     * @return void
     */
    public static function renderPage()
    {
        ?><div class="wrap">

            <h2><?= get_admin_page_title(); ?></h2>
            
            <form method="post" action="<?= esc_url(admin_url('options.php')); ?>">
                <?php

                settings_fields(SITESAUCE_DEPLOYMENTS_OPTIONS_KEY);
                do_settings_sections(SITESAUCE_DEPLOYMENTS_OPTIONS_KEY);

                submit_button('Save Settings', 'primary', 'submit', false);

                ?>
            </form>

        </div><?php
    }
}
