<?php
get_header();
$page_id = get_the_ID();
$parent_id = wp_get_post_parent_id(get_the_ID());
$page_title = get_the_title();
?>
<main class="fx-col-center" id="page-main">
    <?php
    // Banner section
    echo get_template_part("templates/banner", "post", ["title" => $page_title]);
    // Breadcrumbs
    if ($parent_id): ?>
    <div class="container container__xl" id="breadcrumbs">
        <a href="<?php echo get_permalink($parent_id); ?>"><?php echo get_the_title($parent_id); ?></a>
        <span>
            <?php echo $page_title; ?>
        </span>
    </div>
    <?php endif;
    ?>
    <!-- Contents -->
    <div id="layout-wrapper">
        <div class="col col__side col__left">
            <?php echo get_sidebar("secondary"); ?>
        </div>
        <div class="col col__center fx-col-center">
            <div class="container container__full__pc generic-contents" id="contents">
                <?php if (have_posts()):
                  while (have_posts()):
                    the_post();
                    // Metabox
                    echo get_template_part("templates/post", "metabox", ["parent_id" => $parent_id]);
                    // Post contents
                    echo get_the_content();
                  endwhile;
                endif; ?>
            </div>
        </div>
        <div class="col col__side col__right">
            <?php echo get_sidebar("tertiary"); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>
