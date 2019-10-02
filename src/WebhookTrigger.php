<?php

namespace Sitesauce\Wordpress;

class WebhookTrigger
{
    /**
     * When a post is saved or updated, fire this
     *
     * @param int $id
     * @param object $post
     * @param bool $update
     * @return void
     */
    public static function triggerSavePost($id, $post, $update)
    {
        if (wp_is_post_revision($id) || wp_is_post_autosave($id)) {
            return;
        }

        $statuses = apply_filters('sitesauce_deployments_post_statuses', ['publish', 'private', 'trash'], $id, $post);

        if (!in_array(get_post_status($id), $statuses, true)) {
            return;
        }

        self::fireWebhook();
    }

    /**
     * Fire a request to the webhook when a term has been created.
     *
     * @param int $id
     * @param int $post
     * @param string $tax_slug
     * @return void
     */
    public static function triggerSaveTerm($id, $tax_id, $tax_slug)
    {
        self::fireWebhook();
    }

    /**
     * Fire a request to the webhook when a term has been removed.
     *
     * @param int $id
     * @param int $post
     * @param string $tax_slug
     * @param object $term
     * @param array $object_ids
     * @return void
     */
    public static function triggerDeleteTerm($id, $tax_id, $tax_slug, $term, $object_ids)
    {
        self::fireWebhook();
    }

    /**
     * Fire a request to the webhook when a term has been modified.
     *
     * @param int $id
     * @param int $post
     * @param string $tax_slug
     * @return void
     */
    public static function triggerEditTerm($id, $tax_id, $tax_slug)
    {
        self::fireWebhook();
    }

    /**
     * Fire off a request to the webhook
     *
     * @return WP_Error|array
     */
    public static function fireWebhook()
    {
        $hook = sitesauce_deployments_get_build_hook();

        if (!$hook) {
            return;
        }

        if (false === filter_var($hook, FILTER_VALIDATE_URL)) {
            return;
        }

        do_action('sitesauce_deployments_before_fire_webhook');

        $return = file_get_contents($hook);

        do_action('sitesauce_deployments_after_fire_webhook');

        return $return;
    }
}
