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
        // $asset_file = include(plugin_dir_path(__FILE__) . 'build/index.asset.php');
        // wp_register_style("lqb-main", plugin_dir_url(__FILE__) . "build/index.css");
        // wp_register_script("leBlockType", plugin_dir_url(__FILE__) . "build/index.js", array_merge($asset_file['dependencies'], ['wp-blocks', 'wp-element', 'wp-editor']), $asset_file['version']);
        register_block_type(__DIR__, [
            "render_callback" => [$this, 'theHTML'],
        ]);
    }

    function theHTML($attributes) {
        if(!is_admin()) {
            $asset_file = include(plugin_dir_path(__FILE__) . 'build/frontend.asset.php');
            wp_enqueue_script('lqb-frontend', plugins_url( 'build/frontend.js', __FILE__ ), $asset_file['dependencies'], $asset_file['version'],         [
            'in_footer' => true,
        ]);
            wp_enqueue_style("lqb-frontend-styles", plugin_dir_url(__FILE__) . "build/frontend.css");
        }
        ob_start();?>
<div class="lqb-update-me">
    <pre style="display: none;"><?php echo wp_json_encode($attributes) ?></pre>
</div>
<?php return ob_get_clean();
    }
}

$leQuizBlock = new LeQuizBlock();