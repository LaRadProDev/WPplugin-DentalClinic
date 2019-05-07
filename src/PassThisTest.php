<?php

namespace PassThisTest;

use PassThisTest\Support\View;
use PassThisTest\Support\CPT;
use PassThisTest\Metaboxes\AnswerMetaBox;
use PassThisTest\Metaboxes\ExplanationMetaBox;
use PassThisTest\REST\CustomTaxonomies;
use PassThisTest\Support\Taxonomy;
use PassThisTest\Support\PluginActivator;
use PassThisTest\Support\PluginDeactivator;
use PassThisTest\Shortcodes\PassThisTestUI;
use PassThisTest\Actions\FetchQuestions;
use PassThisTest\Actions\SaveAnswers;
use PassThisTest\Actions\SaveToHistory;
use PassThisTest\Actions\GetStats;
use PassThisTest\Actions\FetchHistoryQuestions;
use PassThisTest\Actions\ToggleMarked;
use PassThisTest\Models\Taxonomy as Tax;
use PassThisTest\Models\Question;
use PassThisTest\Models\Stats;
use PassThisTest\Actions\GetQuestionsNum;

class PassThisTest
{
    public static $folder_name = 'pass-this-test';

    public static function run()
    {
        $instance = new static;
        $instance->register_hooks();
        $instance->add_actions();
        $instance->init_tepmplate_engine();
        $instance->init_shortcodes();
        $instance->init_ajax_actions();
        $instance->register_post_types();
        $instance->register_taxonomies();
        $instance->register_meta_boxes();
        $instance->init_rest_endpoints();

        // ->map(function($item) {
        //     return $item->count ? $item->terms : false;
        // })->filter(function($item) {
        //     return $item ? $item : false;
        // })
        // dump(get_current_user_id());

        // dump(Tax::whereTaxonomy('years')->with(['terms.questions:ID', 'terms.questions.histories' => function($q) {
        //     $q->whereUserId(get_current_user_id());
        // }])->get()->toArray());

        // dump((new Question)->with('histories')->get());
    }

    protected function register_hooks()
    {
        $plugin_root = dirname(dirname(__FILE__));

		register_activation_hook( $plugin_root . '/' . PassThisTest_MAIN_FILE_NAME . '.php', array(PluginActivator::class, 'activate') );
		register_deactivation_hook( $plugin_root . '/' . PassThisTest_MAIN_FILE_NAME . '.php', array(PluginDeactivator::class, 'deactivate') );
    }

    protected function init_tepmplate_engine()
    {
        $loader = new \Twig_Loader_Filesystem(dirname(dirname(__FILE__)) . '/resources/' . View::$dirname);
        $twig = new \Twig_Environment($loader, array(
            'cache' => false
        ));

        View::$engine = $twig;
    }

    protected function init_rest_endpoints()
    {
        (new CustomTaxonomies())->register_routes();
    }

    protected function register_post_types()
    {
        (new CPT('Question'))->register();
    }

    protected function register_meta_boxes()
    {
        new AnswerMetaBox();
        new ExplanationMetaBox();
    }

    protected function register_taxonomies()
    {
        (new Taxonomy('Categories', null, 'medical_categories',[
            'show_admin_column' => true
        ]))->addPostType('question')->setHierarchical()->register();
        
        (new Taxonomy('Years', null, null, [
            'show_admin_column' => true
        ]))->addPostType('question')->setHierarchical()->register();
    }

    protected function add_actions()
    {
        add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts' ) );
    }

    public function add_admin_scripts($hook)
    {
        global $post;

        if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
            if ( 'question' === $post->post_type ) {
                wp_enqueue_script(  
                    'editable-radio', 
                    plugins_url(PassThisTest::$folder_name . '/static/admin/js/bundle.js'), 
                    array(),
                    null,
                    true
                );
                wp_localize_script( 'editable-radio', 'ptt', 
                    array(
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'plugin_url' => plugins_url('pass-this-test'),
                        'base_rest_url' => get_site_url() . '/wp-json/pass-this-test/v1/',
                        'base_url' => get_site_url(),
                        'nonce' => wp_create_nonce('wp_rest')
                    )
                );
            }
        }
    }

    protected function init_shortcodes()
    {
        PassThisTestUI::add_shortcode();
    }

    protected function init_ajax_actions()
    {
        FetchQuestions::listen(true);
        SaveAnswers::listen(true);
        SaveToHistory::listen(true);
        GetStats::listen(true);
        FetchHistoryQuestions::listen(true);
        ToggleMarked::listen(true);
        GetQuestionsNum::listen(true);
    }

}