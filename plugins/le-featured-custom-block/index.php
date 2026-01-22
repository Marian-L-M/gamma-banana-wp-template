<?php 
/*
    Plugin Name: Le Featured Custom Block
    Description: Feature a custom block
    Version: 1.0
    Author: Marian Maschke
    Author URI: https://nama-tamagao.dev

    */

if(!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'inc/generate-featured-post.php';

class LeFeaturedBlock {
    public function __construct() {
        add_action("init", [$this, 'adminAssets']);
        add_action("rest_api_init", [$this, 'featuredHTML']);
    }

    public function adminAssets() {
        register_block_type(__DIR__, [
            "render_callback" => [$this, 'renderCallback'],
        ]);
    }

    public function renderCallback($attributes) {
        if($attributes["featuredId"]) {
            return generateFeaturedPostHTML($attributes["featuredId"]);
        }
        else {
            return NULL;
        }
    }

    public function featuredHTML() {
        register_rest_route('featuredPost/v1', "getHTML", [
            'methods' => WP_REST_SERVER::READABLE,
            'callback' => [$this, 'getFeaturedHTML']
        ]);
        
    }
    public function getFeaturedHTML($data) {
        return generateFeaturedPostHTML($data["postID"]);
    }
}

$LeFeaturedBlock = new LeFeaturedBlock();