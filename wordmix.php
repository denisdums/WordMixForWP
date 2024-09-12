<?php

use WordMix\hooks\Admin;
use WordMix\hooks\API;
use WordMix\hooks\Assets;
use WordMix\hooks\Expose;
use WordMix\hooks\Preview;
use WordMix\hooks\Theming;

/**
 * Plugin Name:       Wordmix
 * Description:       Wordmix headless plugin.
 * Requires at least: 5.7
 * Requires PHP:      7.4
 * Version:           0.9.4
 * Author:            denisdums
 * Author URI:        https://denisdums.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wordmix
 *
 * @package           wordmix
 */
class Wordmix
{
    public function boot(): void
    {
        $this->setConstants();
        $this->registerAutoload();

        Assets::boot();
        Theming::boot();
        API::boot();
        Expose::boot();
        Preview::boot();
        Admin::boot();
    }

    public function setConstants(): void
    {
        define('WORDMIX_DIR', plugin_dir_path(__FILE__));
        define('WORDMIX_URL', plugin_dir_url(__FILE__));
    }

    public function registerAutoload(): void
    {
        require_once WORDMIX_DIR . '/vendor/autoload.php';
    }
}

$wordmix = new Wordmix();
$wordmix->boot();
