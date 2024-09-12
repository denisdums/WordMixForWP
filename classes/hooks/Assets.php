<?php

namespace WordMix\hooks;

use WordMix\helpers\Options;

class Assets extends BootLoadClass
{
    public function register(): void
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminAssets']);
        add_action('enqueue_block_assets', [$this, 'enqueueAdminAssets']);
    }

    public function enqueueAdminAssets(): void
    {
        wp_register_style('wordmix-admin-style', Options::get('wordmixRemixUrl') . "/app/styles/wordpress.css");
        wp_enqueue_style('wordmix-admin-style');
    }
}
