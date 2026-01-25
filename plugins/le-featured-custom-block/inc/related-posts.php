<?php

function relatedPostsHTML($id) {
    $allowedPostTypes = ['roadmap', 'projects', 'features', 'posts', 'guides', "wikis", "notes"];
    $relatedPosts = new WP_Query([
        'posts_per_page' => 1,
        'post_type' => $allowedPostTypes,
        'meta_query' => [
            "key" => "featuredPost",
        ]
    ]);
    return "ello govna" ;
}