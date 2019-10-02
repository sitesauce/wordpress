<?php

namespace Sitesauce\Wordpress;

class Field
{
    /**
     * Render an input[type=url] field
     *
     * @param array $args
     * @return void
     */
    public static function url($args = [])
    {
        ?><div>
            <input type="url" class="regular-text" name="<?= esc_attr($args['name']); ?>" placeholder="<?= esc_url($args['placeholder']); ?>" value="<?= esc_url($args['value']); ?>" required>
            <?= !empty($args['description']) ? "<p class=\"description\">{$args['description']}</p>" : ''; ?>
        </div><?php
    }
}
