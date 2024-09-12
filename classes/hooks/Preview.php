<?php

namespace WordMix\hooks;

use WordMix\helpers\Options;

class Preview extends BootLoadClass
{
    public function register(): void
    {
        add_filter('preview_post_link', [$this, 'overridePreviewLink']);
    }

    public function overridePreviewLink($preview_link): string
    {
        $url = parse_url($preview_link);
        $params = $url['query'];
        return Options::get('wordmixRemixUrl') . "/preview?" . $params;
    }
}



