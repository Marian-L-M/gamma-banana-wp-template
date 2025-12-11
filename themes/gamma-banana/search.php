<?php
get_header();
$page_title = "Search results";
$page_subtitle = "Keyword: " . get_search_query();
$pagination_args = [
  "format" => "/page/%#%/#contents",
  "mid_size" => 2,
  "prev_text" => __("Prev"),
  "next_text" => __("Next"),
];
?>
<main class="fx-col-center gap-2" id="page-main">
    <?php generate_page_banner("/common/banner/banner-top.webp", $page_title, $page_subtitle); ?>
    <div class="gap-1" id="layout-wrapper">
        <div class="col col__side col__left">
            <?php echo get_sidebar("secondary"); ?>
        </div>
        <div class="col col__center fx-col-center">
            <div class="container container__full__pc posts posts__list" id="contents">
                <?php
                while (have_posts()):
                  the_post(); 
                  echo get_template_part("templates/post", "list-dynamic");
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