<?php
get_header();
$page_title = get_the_title();
$paged = get_query_var("paged", 1);
$today = date("Ymd");
$query_args = [
  "post_type" => ["post"],
  "posts_per_page" => 1,
  "post_status" => "publish",
  "paged" => $paged,
  "order" => "DESC",
  "orderby" => "meta_value_num",
  "meta_key" => "event_date",
];
$pagination_args = [
  "format" => "/page/%#%/#contents",
  "mid_size" => 2,
  "prev_text" => __("Prev"),
  "next_text" => __("Next"),
];
?>
<main class="fx-col-center gap-half" id="page-main">
    <?php generate_page_banner("/common/banner/banner-top.webp", $page_title); ?>
    <div id="layout-wrapper">
        <div class="col col__side col__left">
            <?php echo get_sidebar("secondary"); ?>
        </div>
        <div class="col col__center fx-col-center">
            <div class="container container__full__pc fx-col gap-1" id="contents">
                <div class="container container__full__pc posts posts__list" id="contents">
                    <?php
                    global $wp_query;
                    $query = new WP_Query($query_args);
                    $tmp_query = $wp_query;
                    $wp_query = $query;

                    if ($query):
                      while ($query->have_posts()):
                        $query->the_post();
                        echo get_template_part("templates/post", "list-item");
                      endwhile;
                    endif;
                    echo get_the_posts_pagination($pagination_args);
                    $wp_query = $tmp_query;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
        <div class="col col__side col__right">
            <?php echo get_sidebar("tertiary"); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>
