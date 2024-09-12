<?php

namespace WordMix\hooks;

class Expose extends BootLoadClass
{
    public function register(): void
    {
        add_action('init', [$this, 'registerExposeEndpoints']);
        add_action('parse_request', [$this, 'handleExposeEndpoints']);
    }

    public function exposeThemeHeadStyles(): void
    {
        header('Content-Type: text/css');

        ob_start();
        wp_enqueue_scripts();
        wp_print_styles();
        $styles = ob_get_clean();

        $dom = new \DOMDocument();
        $dom->loadHTML($styles);
        $styles = '';
        $styleTags = $dom->getElementsByTagName('style');

        foreach ($styleTags as $styleTag) {
            $styles .= $styleTag->nodeValue;
        }

        echo $styles;
        exit;
    }

    public function registerExposeEndpoints(): void
    {
        add_rewrite_rule('expose/head_styles.css', 'index.php?expose_head_styles=true', 'top');
        add_rewrite_tag('%expose_head_styles%', '([^&]+)');
    }

    public function handleExposeEndpoints(\WP $wp): \WP
    {
        if (isset($wp->query_vars['attachment']) && $wp->query_vars['attachment'] === 'head-styles.css') {
            $this->exposeThemeHeadStyles();
            return $wp;
        }

        return $wp;
    }
}



