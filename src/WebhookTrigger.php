<?php

namespace Sitesauce\Wordpress;

class WebhookTrigger
{
    /**
     * When a post is saved or updated, fire this
     *
     * @param int $id
     * @return void
     */
    public static function triggerSavePost($post_id)
    {
        if (get_post_status($post_id) !== 'publish') {
            return;
        }

        self::fireWebhook();
    }

    /**
     * Fire a request to the webhook when a term has been created.
     *
     * @return void
     */
    public static function triggerTrashedPost()
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
        if (filter_var($hook = sitesauce_deployments_get_build_hook(), FILTER_VALIDATE_URL) === false) {
            return;
        }

        return file_get_contents($hook);
    }
}
