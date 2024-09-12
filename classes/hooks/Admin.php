<?php

namespace WordMix\hooks;

class Admin extends BootLoadClass
{
    public function register(): void
    {
        add_action('admin_menu', [$this, 'addAdminPage']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminReactApp']);
    }

    public function addAdminPage(): void
    {
        add_submenu_page(
            'options-general.php',
            'WordMix',
            'WordMix',
            'manage_options',
            'wordmix',
            [$this, 'renderAdminPage']
        );
    }

    public function renderAdminPage(): void
    {
        echo '<div id="wordmix-admin-app"></div>';
    }

    public function enqueueAdminReactApp(): void
    {
        wp_enqueue_script('wordmix-admin-app', WORDMIX_URL . 'admin/dist/bundle.js', null, null, true);
        wp_localize_script('wordmix-admin-app', 'wordmix', [
            'root' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest')
        ]);
    }
}
