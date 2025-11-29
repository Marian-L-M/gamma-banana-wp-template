<?php
get_header();
$page_id = get_the_ID();
$parent_id = wp_get_post_parent_id(get_the_ID());
$page_title = "404 - Page not found";
?>
<main class="fx-col-center" id="post-main">
    <?php // Banner section

echo get_template_part("templates/banner", "post", ["title" => $page_title]);
// Breadcrumbs
?>
</main>
<?php get_footer(); ?>
