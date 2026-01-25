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
require_once plugin_dir_path(__FILE__) . 'inc/related-posts.php';

class LeFeaturedBlock {
    public function __construct() {
        add_action("init", [$this, 'adminAssets']);
        add_action("rest_api_init", [$this, 'featuredHTML']);
        add_filter('the_content', [$this, "addRelatedPosts"]);
    }

    public function addRelatedPosts($content) {
        $allowedPostTypes = ['roadmap', 'projects', 'features', 'post', 'guides', "wikis", "notes"];
        if(is_singular($allowedPostTypes) && in_the_loop() && is_main_query()) {
            return $content . relatedPostsHTML(get_the_id());
        }
        return $content;
    }

    public function adminAssets() {
        $allowedPostTypes = ['roadmap', 'projects', 'features', 'post', 'guides', "wikis", "notes"];

        foreach($allowedPostTypes as $postType) {
            register_meta($postType, "featuredpostmeta", [
                'show_in_rest' => true,
                'type' => 'number',
                'single' => false
            ]);
        }

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
        return generateFeaturedPostHTML($data["postId"]);
    }
}

$LeFeaturedBlock = new LeFeaturedBlock();