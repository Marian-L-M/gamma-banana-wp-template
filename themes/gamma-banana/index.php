<?php
get_header();
$page_title = get_the_title();
$pagination_args = [
  "format" => "/page/%#%/#contents",
  "mid_size" => 2,
  "prev_text" => __("Prev"),
  "next_text" => __("Next"),
];
?>
<main class="fx-col-center" id="page-main">
    <?php generate_page_banner("/common/banner/banner-top.webp", $page_title); ?>
    <div id="layout-wrapper">
        <div class="col col__side col__left">
            <?php echo get_sidebar("secondary"); ?>
        </div>
        <div class="col col__center fx-col-center">
            <div class="container container__full__pc posts posts__list" id="contents">
                <?php
                while (have_posts()):
                  the_post(); ?>
                <h3><a href="<?php echo get_the_permalink(); ?>"></a><?php echo get_the_title(); ?></h3>
                <?php
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
