<?php

function relatedPostsHTML($id) {
    $allowedPostTypes = ['roadmap', 'projects', 'features', 'post', 'guides', "wikis", "notes"];
    $relatedPosts = new WP_Query([
        'posts_per_page' => 1,
        'post_type' => $allowedPostTypes,
        'meta_query' => [
            "key" => "featuredpostmeta",
            "compare" => "=",
            "value" => $id,
        ]
    ]);
    
    ob_start();
    if($relatedPosts -> found_posts()):?>
<p><?php the_title()?> is mentioned in:</p>
<ul>
    <?php while($relatedPosts -> have_posts()): $relatedPosts -> the_post(); ?>
    <li>
        <a href="<?php the_permalink()?>"><?php the_title()?></a>
    </li>
    <?php endwhile;?>
</ul>
<?php
    else: 
        return "no related posts for" . $id;
    endif;
    wp_reset_postdata();
    return ob_get_clean();
}