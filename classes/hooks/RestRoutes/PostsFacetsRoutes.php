<?php

namespace WordMix\hooks\RestRoutes;

use WordMix\hooks\BootLoadClass;
use WP_REST_Request;
use WP_REST_Response;

class PostsFacetsRoutes extends BootLoadClass
{
    public function register(): void
    {
        add_action('rest_api_init', [$this, 'registerRestCollectionRoutes']);
    }

    public function registerRestCollectionRoutes(): void
    {
        register_rest_route('wp/v2', '/posts/facets/', array(
            'methods' => 'GET',
            'permission_callback' => (fn() => current_user_can('manage_options')) ? '__return_true' : '__return_false',
            'callback' => [$this, 'getFacetsCallback'],
        ));

    }

    public function getFacetsCallback(WP_REST_Request $request): WP_REST_Response
    {
        $taxonomies = get_taxonomies(['object_type' => ['post']], false);
        $values = [];

        foreach ($taxonomies as $taxonomy) {
            $terms = get_terms([
                'taxonomy' => $taxonomy->name,
                'hide_empty' => true,
            ]);

            $values[] = [
                "type" => "taxonomy",
                "label" => $taxonomy->label,
                "slug" => $taxonomy->name,
                "values" => array_map([$this, 'getTermFacetValue'], $terms)
            ];
        }

        return new WP_REST_Response($values);
    }

    public function getTermFacetValue(\WP_Term $term): array
    {
        return [
            "name" => $term->name,
            "value" => $term->term_id,
        ];
    }
}



