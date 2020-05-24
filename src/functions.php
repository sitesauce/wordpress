<?php

if (!function_exists('sitesauce_deployments_get_options')) {
    /**
     * Return the plugin settings/options
     *
     * @return array
     */
    function sitesauce_deployments_get_options()
    {
        return get_option(SITESAUCE_DEPLOYMENTS_OPTIONS_KEY);
    }
}


if (!function_exists('sitesauce_deployments_get_build_hook')) {
    /**
     * Return the webhook url
     *
     * @return string|null
     */
    function sitesauce_deployments_get_build_hook()
    {
        $options = sitesauce_deployments_get_options();
        return isset($options['build_hook']) ? $options['build_hook'] : null;
    }
}

if (!function_exists('sitesauce_deployments_fire_webhook')) {
    /**
     * Fire a request to the webhook.
     *
     * @return void
     */
    function sitesauce_deployments_fire_webhook()
    {
        \Sitesauce\Wordpress\WebhookTrigger::fireWebhook();
    }
}

if (!function_exists('sitesauce_deployments_force_fire_webhook')) {
    /**
     * Fire a request to the webhook immediately.
     *
     * @return void
     */
    function sitesauce_deployments_force_fire_webhook()
    {
        \Sitesauce\Wordpress\WebhookTrigger::fireWebhook();
    }
}

if (!function_exists('sitesauce_deployments_fire_webhook_save_post')) {
    /**
     * Fire a request to the webhook when a post is saved.
     *
     * @param int $id
     * @param WP_Post $post
     * @param boolean $update
     * @return void
     */
    function sitesauce_deployments_fire_webhook_save_post($id, $post, $update)
    {
        \Sitesauce\Wordpress\WebhookTrigger::triggerSavePost($id, $post, $update);
    }
    add_action('save_post', 'sitesauce_deployments_fire_webhook_save_post');
}

if (!function_exists('sitesauce_deployments_fire_webhook_created_term')) {
    /**
     * Fire a request to the webhook when a post is deleted.
     *
     * @param int $id
     * @param int $post
     * @param string $tax_slug
     * @return void
     */
    function sitesauce_deployments_fire_webhook_thrashed_post($id, $tax_id, $tax_slug)
    {
        \Sitesauce\Wordpress\WebhookTrigger::triggerTrashedPost($id, $tax_id, $tax_slug);
    }
    add_action('thrased_post', 'sitesauce_deployments_fire_webhook_thrashed_post');
}
