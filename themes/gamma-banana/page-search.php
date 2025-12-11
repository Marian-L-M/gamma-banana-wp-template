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
        <div class="col col__center fx-col-center gap-half">
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
            <div class="container  container__lg container_form" id="search-form-container">
                <form method="get" action="<?php echo esc_url(get_site_url())?>" class="search-form" id="search-form">
                    <div class="search-form-group">
                        <label for="input-search">Perform a new search:</label>
                        <div class="search-form-input-row">
                            <input placeholder="What are you looking for?" type="search" name="s" id="input-search">
                            <button type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col col__side col__right">
            <?php echo get_sidebar("tertiary"); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>