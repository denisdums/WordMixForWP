<?php

namespace WordMix\hooks;

use WordMix\hooks\RestRoutes\OptionsRoutes;
use WordMix\hooks\RestRoutes\PostsCollectionRoutes;
use WordMix\hooks\RestRoutes\PostsFacetsRoutes;
use WP_REST_Response;

class API extends BootLoadClass
{
    public function register(): void
    {
        add_action('init', [$this, 'registerPostTypesCollectionsFilters']);
        add_filter('rest_request_after_callbacks', [$this, 'addCustomHTTPHeaders'], 100, 3);
        add_filter('rest_url', [$this, 'OverrideRestUrl'], 100);

        PostsFacetsRoutes::boot();
        PostsCollectionRoutes::boot();
        OptionsRoutes::boot();
    }

    public function registerPostTypesCollectionsFilters()
    {
        $post_types = get_post_types();
        foreach ($post_types as $post_type) {
            add_filter('rest_' . $post_type . '_collection_params', [$this, 'syncPerPageOption'], 100);
        }
    }

    public function addCustomHTTPHeaders($response, $handler, $request): mixed
    {
        if (!$response instanceof WP_REST_Response) {
            return $response;
        }

        $perPage = $request->get_param('per_page');
        if ($perPage) {
            $response->header('X-WP-PerPage', $perPage);
        }

        return $response;
    }

    public function syncPerPageOption(array $params): array
    {
        $params['per_page']['default'] = get_option('posts_per_page') ?? 10;
        return $params;
    }

    public function OverrideRestUrl(string $url): string
    {
        return str_replace(home_url(), site_url(), $url);
    }
}



