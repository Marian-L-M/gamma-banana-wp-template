<?php 
/*
    Plugin Name: Le Quiz Block
    Description: Give your readers a multiple choice question.
    Version: 1.0
    Author: Marian Maschke
    Author URI: https://nama-tamagao.dev

    */

if(!defined('ABSPATH')) exit;

class LeQuizBlock {
    function __construct() {
        add_action("init", [$this, 'adminAssets']);
    }

    function adminAssets() {
        wp_register_style("lqb-main", plugin_dir_url(__FILE__) . "build/index.css");
        wp_register_script("leBlockType", plugin_dir_url(__FILE__) . "build/index.js", ["wp-blocks", "wp-element", "wp-editor"]);
        register_block_type("theme-custom-blocks/le-quiz-block", [
            "editor_script" => "leBlockType",
            "editor_style" => "lqb-main",
            "render_callback" => [$this, 'theHTML'],
        ]);
    }

    function theHTML($attributes) {
        if(!is_admin()) {
            // wp_enqueue_script('attentionFrontend', plugin_dir_url(__FILE__) . 'build/frontend.js', array('wp-element'), '1.0', true); // For block editor
            wp_enqueue_script('lqb-frontend', plugin_dir_url(__FILE__) . 'build/frontend.js', ['wp-element',  'wp-blocks'], '1.0', true);
            wp_register_style("lqb-frontend-styles", plugin_dir_url(__FILE__) . "build/frontend.css");
        }
        ob_start();?>
<div class="lqb-update-me"></div>
<?php return ob_get_clean();
    }
}

$leQuizBlock = new LeQuizBlock();