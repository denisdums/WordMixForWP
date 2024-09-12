<?php

namespace WordMix\hooks\RestRoutes;

use WordMix\hooks\BootLoadClass;
use WP_Error;

class OptionsRoutes extends BootLoadClass
{
    public function register(): void
    {
        add_action('rest_api_init', [$this, 'registerRestOptionRoutes']);
    }

    public function registerRestOptionRoutes(): void
    {
        register_rest_route('wordmix', '/save-option/', array(
            'methods' => 'POST',
            'permission_callback' => (fn() => current_user_can('manage_options')) ? '__return_true' : '__return_false',
            'callback' => [$this, 'saveOptionAPICallback'],
            'args' => [
                'option_name' => [
                    'required' => true,
                ],
                'option_value' => [
                    'required' => true,
                ]
            ],
        ));

        register_rest_route('wordmix', '/get-option/(?P<option_name>[a-zA-Z0-9_-]+)', array(
            'methods' => 'GET',
            'permission_callback' => (fn() => current_user_can('manage_options')) ? '__return_true' : '__return_false',
            'callback' => [$this, 'readOptionAPICallback'],
        ));
    }

    public function readOptionAPICallback($data): mixed
    {
        $option_name = $data['option_name'];
        return get_option($option_name, null);
    }

    public function saveOptionAPICallback($data): WP_Error|string
    {
        $option_name = $data['option_name'];
        $option_value = $data['option_value'];
        return update_option($option_name, $option_value);
    }
}



