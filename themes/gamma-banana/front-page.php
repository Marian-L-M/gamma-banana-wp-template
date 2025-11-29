<?php
get_header();
$page_title = "Clouds and Spaceships";
$today = date("Ymd");
$query_args = [
  "post_type" => ["roadmap"],
  "post_status" => "publish",
  "posts_per_page" => -1,
  "order" => "ASC",
  //   "orderby" => "meta_value",
  "orderby" => "meta_value_num",
  "meta_key" => "event_date",
  "meta_query" => [
    [
      "key" => "event_date",
      "compare" => ">=",
      "value" => $today,
      "type" => "numeric",
    ],
  ],
];
?>
<main class="fx-col-center gap-half" id="page-main">
    <?php generate_page_banner("/common/banner/banner-top.webp", $page_title); ?>
    <div id="layout-wrapper">
        <div class="col col__side col__left">
            <?php echo get_sidebar("secondary"); ?>
        </div>
        <div class="col col__center fx-col-center">
            <div class="container container__full__pc fx-col gap-1" id="contents-roadmap">
                <h2>Upcoming Developments</h2>
                <div class="container container__full__pc posts posts__list" id="contents">
                    <?php
                    $query = new WP_Query($query_args);

                    if ($query->have_posts()):
                      while ($query->have_posts()):
                        $query->the_post();
                        echo get_template_part("templates/post", "list-item");
                      endwhile;
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>
                <a href="<?php echo get_post_type_archive_link("roadmap"); ?>" class="btn btn__rm btn__anim-bar"><span
                        class="anim-inner">View all</span></a>
            </div>
        </div>
        <div class="col col__side col__right">
            <?php echo get_sidebar("tertiary"); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>
