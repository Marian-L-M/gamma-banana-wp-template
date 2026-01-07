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
        wp_register_script("leBlockType", plugin_dir_url(__FILE__) . "build/index.js", ["wp-blocks", "wp-element"]);
        register_block_type("theme-custom-blocks/le-quiz-block", [
            "editor_script" => "leBlockType",
            "render_callback" => [$this, 'theHTML'],
        ]);
    }

    function theHTML($attributes) {
        ob_start();?>
<h3>Today the sky is <?php echo $attributes['skyColor'] ?> and the grills are <?php echo $attributes['grassColor'] ?>!!!
</h3>
<?php return ob_get_clean();
    }
}

$leQuizBlock = new LeQuizBlock();