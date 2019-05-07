<?php

namespace PassThisTest\REST;

use \WP_REST_Controller;
use \WP_REST_Server;
use \WP_REST_Response;
use PassThisTest\Models\Taxonomy as Tax;

class CustomTaxonomies extends WP_REST_Controller {
    public function register_routes() {
        $version = '1';
        $namespace = 'pass-this-test/v' . $version;
        $base = 'custom-taxonomies';

        add_action( 'rest_api_init', function () use ($namespace, $base) {
            register_rest_route( $namespace, '/' . $base, 
                array(
                    'methods'  => 'GET',
                    'callback' => array( $this, 'get_items' ),
                )
            );
        });
    }

    public function get_items($request) {
        $params = $request->get_query_params();

        $data = Tax::whereTaxonomy($params['tax_slug'])->with(['terms.questions:ID', 'terms.questions.histories' => function($q) {
            $q->whereUserId(get_current_user_id());
        }])->get()->map(function($item) {
            return $item->count ? $item->terms : false;
        })->filter(function($item) {
            return $item ? $item : false;
        })->toArray();

        return new WP_REST_Response( $data, 200 );
    }
}