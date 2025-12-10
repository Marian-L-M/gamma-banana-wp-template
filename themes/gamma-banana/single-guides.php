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