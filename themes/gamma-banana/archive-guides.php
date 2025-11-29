<?php
get_header();
$taxonomy = get_queried_object();
$page_title = "Guides";
$pagination_args = [
  "format" => "/page/%#%/#contents",
  "mid_size" => 2,
  "prev_text" => __("Prev"),
  "next_text" => __("Next"),
];
?>
<main class="fx-col-center" id="page-main">
    <?php generate_page_banner("/common/banner/banner-top.webp", $page_title); ?>
    <div class="pv-half" id="layout-wrapper">
        <div class="col col__side col__left">
            <?php echo get_sidebar("secondary"); ?>
        </div>
        <div class="col col__center fx-col-center gap-half">
            <!-- Current -->
            <div class="container container__full__pc posts posts__list" id="contents">
                <h2>Current Guides</h2>
                <?php
                while (have_posts()):
                  the_post();
                  echo get_template_part("templates/post", "list-item");
                endwhile;
                the_posts_pagination($pagination_args);
                ?>
            </div>
        </div>
        <div class="col col__side col__right">
            <?php echo get_sidebar("tertiary"); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>
