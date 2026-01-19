<?php 
/*
    Plugin Name: Le Featured Custom Block
    Description: Feature a custom block
    Version: 1.0
    Author: Marian Maschke
    Author URI: https://nama-tamagao.dev

    */

if(!defined('ABSPATH')) exit;

class LeFeaturedBlock {
    public function __construct() {
        add_action("init", [$this, 'adminAssets']);
    }

    public function adminAssets() {
        register_block_type(__DIR__, [
            "render_callback" => [$this, 'theHTML'],
        ]);
    }

    public function theHTML($attributes) {
        ob_start();?>
<div class="lfb-update-me">
    <pre style="display: none;"><?php echo wp_json_encode($attributes) ?></pre>
</div>
<?php return ob_get_clean();
    }
}

$LeFeaturedBlock = new LeFeaturedBlock();