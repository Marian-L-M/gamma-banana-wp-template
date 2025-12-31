<?php
get_header();
$page_id = get_the_ID();
$parent_id = wp_get_post_parent_id(get_the_ID());
?>
<main class="fx-col-center gap-half" id="post-main">
    <?php echo get_template_part("templates/banner", "post"); ?>
    <!-- Contents -->
    <div id="layout-wrapper">
        <div class="col col__side col__left">
            <?php echo get_sidebar("secondary"); ?>
        </div>
        <div class="col col__center fx-col-center">
            <div class="container container__full__pc likes" id="likes">
                <?php 
                $like_count = new WP_Query([
                    'post_type' => "likes",
                    'meta_query' => [
                        [
                            'key' => 'liked_post_id',
                            'compare' => '=',
                            'value' => $page_id
                        ]
                    ],
                ]) ;
                
                $is_active = "inactive";
                $like_id;
                
                if(is_user_logged_in()) {

                    $exist_like_query = new WP_Query([
                        'author' => get_current_user_id(),
                        'post_type' => "likes",
                        'meta_query' => [
                            [
                                'key' => 'liked_post_id',
                                'compare' => '=',
                                'value' => $page_id
                                ]
                            ],
                            ]) ;
                            
                            if($exist_like_query -> found_posts) {
                                $is_active = "active";
                                $like_id = $exist_like_query->posts[0]->ID;
                            };
                        }
                ?>
                <button class="btn btn__like" id="btn-like" data-id="<?php the_ID() ?>"
                    data-likesid="<?php echo $like_id ?? ''; ?>" data-status="<?php echo $is_active; ?>">
                    <span class="user-like" id="user-like">
                        <span class="active-content">
                            <?php generate_hearts(1, 0, "red"); ?>
                        </span>
                        <span class="inactive-content">
                            <?php generate_hearts(0, 1, "pink"); ?>
                        </span>
                    </span>
                    <span class="like-count" id="like-count"><?php echo $like_count -> found_posts; ?></span>
                </button>
            </div>
            <!-- Contents -->
            <div class="container container__full__pc generic-contents" id="contents">
                <?php if (have_posts()):
                  while (have_posts()):
                    the_post();
                    // Metabox
                    echo get_template_part("templates/post", "metabox", ["parent_id" => $parent_id]);
                    // Post contents
                    the_content();
                  endwhile;
                endif; ?>
            </div>
            <!-- Related items -->
            <?php echo get_template_part("templates/post", "grid-related"); ?>
        </div>
        <div class="col col__side col__right">
            <?php echo get_sidebar("tertiary"); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>