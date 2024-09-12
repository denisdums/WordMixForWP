<?php

namespace WordMix\hooks;

use WP_Theme_JSON_Data;

class Theming extends BootLoadClass
{
    public WP_Theme_JSON_Data|null $themeJson = null;

    public function register(): void
    {
        add_theme_support('custom-logo');

        add_filter('wp_theme_json_data_theme', [$this, 'loadThemeJSON']);
        add_filter('wp_theme_json_data_default', [$this, 'loadThemeJSON']);
        add_filter('wp_theme_json_data_blocks', [$this, 'loadThemeJSON']);
        add_filter('wp_theme_json_data_user', [$this, 'loadThemeJSON']);
    }


    public function loadThemeJSON(WP_Theme_JSON_Data $theme_json): WP_Theme_JSON_Data
    {
        if ($this->themeJson) {
            return $this->themeJson;
        }

        $themeUrl = 'http://host.docker.internal:3000/api/config/theme';

        $c = curl_init($themeUrl);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($c);
        curl_close($c);

        $data = json_decode($data, true) ?? [];
        $this->themeJson = $theme_json->update_with($data);
        return $this->themeJson;
    }
}
