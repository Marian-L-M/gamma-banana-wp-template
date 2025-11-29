<?php
get_header();
$page_id = get_the_ID();
$parent_id = wp_get_post_parent_id(get_the_ID());
$page_title = get_the_title();
$attachment_id = get_post_thumbnail_id();
$sizes = ["medium", "large", "full"];

$image_medium = wp_get_attachment_image_src($attachment_id, $sizes[0]);
$image_large = wp_get_attachment_image_src($attachment_id, $sizes[1]);
$image_full = wp_get_attachment_image_src($attachment_id, $sizes[2]);
?>
<main class="fx-col-center" id="page-main">
    <div class="slide  sticky fx-col-center">
        <h1>First slide</h1>
    </div>
    <div class="slide sticky fx-col-center" style="z-index: 101;">
        <div class="content">
            <h1>Second slide</h1>
        </div>
    </div>
    <div class="slide sticky fx-col-center" style="z-index: 102;">
        <div class="content">
            <h1>third slide</h1>
        </div>
    </div>
</main>
<?php get_footer(); ?>