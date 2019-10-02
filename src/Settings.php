<?php

namespace Sitesauce\Wordpress;

class Settings
{
    /**
     * Setup required hooks for the Settings
     *
     * @return void
     */
    public static function init()
    {
        add_action('admin_init', [__CLASS__, 'register']);
    }

    /**
     * Register settings & fields
     *
     * @return void
     */
    public static function register()
    {
        $key = SITESAUCE_DEPLOYMENTS_OPTIONS_KEY;

        register_setting($key, $key, [__CLASS__, 'sanitize']);
        add_settings_section('general', 'General', '__return_empty_string', $key);
        
        $option = sitesauce_deployments_get_options();

        add_settings_field('build_hook', 'Build Hook', ['Sitesauce\Wordpress\Field', 'url'], $key, 'general', [
            'name' => "{$key}[build_hook]",
            'value' => sitesauce_deployments_get_build_hook(),
            'placeholder' => 'https://app.sitesauce.app/api/build_hooks/...',
            'description' => 'A build hook for the site you want to keep updated. You can get this value on the settings page of your site.'
        ]);
    }

    /**
     * Sanitize user input
     *
     * @var array $input
     * @return array
     */
    public static function sanitize($input)
    {
        if (! empty($input['build_hook'])) {
            $input['build_hook'] = sanitize_text_field($input['build_hook']);

            if (! strpos(parse_url($input['build_hook'], PHP_URL_HOST), 'sitesauce') !== false) {
                $input['build_hook'] = null;

                add_settings_error(SITESAUCE_DEPLOYMENTS_OPTIONS_KEY, SITESAUCE_DEPLOYMENTS_OPTIONS_KEY, 'Please enter a valid build hook.', 'error');
            }

        }

        return $input;
    }
}
