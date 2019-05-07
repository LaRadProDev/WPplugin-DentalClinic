<?php

namespace PassThisTest\Actions;

use PassThisTest\Support\Ajax;

class SaveAnswers extends Ajax {
    protected $action = 'save_answers';

    protected function run() {
        $url = $this->request['url'];
        $parse_url = wp_parse_url( $url); 

        $WP_Query = new \WP_Query();
        $WP_Query->parse_query( $parse_url['query'] );
        $post_id = $WP_Query->query['post'];

        if ($post_id) {
            update_post_meta($post_id, 'answers', $this->request['answers']);
            $this->returnJSON(true);
        }
        $this->returnJSON(false);
    }
}