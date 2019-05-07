<?php

namespace PassThisTest\Shortcodes;

use PassThisTest\PassThisTest;
use PassThisTest\Support\View;

class PassThisTestUI {

    protected $name = 'pass_this_test';
    static $add_script;

    private function __construct() {}

    public static function add_shortcode()
    {
        $instance = new static;

        add_shortcode($instance->name, array($instance, 'handle'));

        add_action('wp_footer', array($instance, 'print_script'));
    }

    public function handle($atts, $content = null) 
    {
        $atts = shortcode_atts( array(
            'registration_uri' => '',
            'login_uri' => ''
        ), $atts );
    
        static::$add_script = true;

        $user_logged_in = is_user_logged_in();

        if (!is_user_logged_in()) {
            return View::compile('shortcodes/not-logged-in.twig', [
                'registration_uri' => $atts['registration_uri'],
                'login_uri' => $atts['login_uri']
            ]);
        }

        return View::compile('shortcodes/pass-this-test.twig', [
            'user_name' => wp_get_current_user()->display_name
        ]);

    }

    public function print_script()
    {
        if ( ! static::$add_script ) {
            return;
        }
        
        wp_enqueue_script(
            'pass_this_test_js',
            plugins_url(PassThisTest::$folder_name . '/static/public/js/bundle.js'),
            array(),
            null,
            true
        );

        wp_localize_script( 'pass_this_test_js', 'ptt', 
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'plugin_url' => plugins_url('pass-this-test'),
                'base_rest_url' => get_site_url() . '/wp-json/pass-this-test/v1/',
                'base_url' => get_site_url(),
                'nonce' => wp_create_nonce('wp_rest')
            )
        );

	    wp_enqueue_style(
		    'pass_this_test_css',
		    plugins_url(PassThisTest::$folder_name . '/static/public/css/main.css'),
		    false,
		    '1.0.0'
	    );
    }

}