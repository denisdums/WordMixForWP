<?php

namespace WordMix\helpers;

use WordMix\hooks\BootLoadClass;

class Options
{
    private static array $options = [];

    public static function get(string $option, $default = null)
    {
        if (isset(self::$options[$option])) {
            return self::$options[$option];
        }
        self::$options[$option] = get_option($option, $default);
        return apply_filters('wordmix_get_option', self::$options[$option], $option);
    }
}
