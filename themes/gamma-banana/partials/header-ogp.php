<!-- Open Graph Meta Tags -->
<meta property="og:locale" content="<?php echo get_locale(); ?>" />
<meta property="og:type" content="<?php echo is_single() ? "article" : "website"; ?>" />
<meta property="og:title" content="<?php echo is_front_page() ? get_bloginfo("name") : wp_get_document_title(); ?>" />
<meta property="og:description"
    content="<?php echo is_front_page() ? get_bloginfo("description") : wp_trim_words(get_the_excerpt(), 30); ?>" />
<meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>" />
<meta property="og:site_name" content="<?php echo get_bloginfo("name"); ?>" />

<?php if (has_post_thumbnail()): ?>
<meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url(null, "large")); ?>" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<?php else: ?>
<meta property="og:image" content="<?php echo esc_url(get_template_directory_uri() . "/img/ogp.png"); ?>" />
<?php endif; ?>

<?php if (is_single()): ?>
<meta property="article:published_time" content="<?php echo get_the_date("c"); ?>" />
<meta property="article:modified_time" content="<?php echo get_the_modified_date("c"); ?>" />
<?php endif; ?>

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?php echo is_front_page() ? get_bloginfo("name") : wp_get_document_title(); ?>" />
<meta name="twitter:description"
    content="<?php echo is_front_page() ? get_bloginfo("description") : wp_trim_words(get_the_excerpt(), 30); ?>" />
<?php if (has_post_thumbnail()): ?>
<meta name="twitter:image" content="<?php echo esc_url(get_the_post_thumbnail_url(null, "large")); ?>" />
<?php endif; ?>
<!-- <meta name="twitter:site" content="@yourtwitterhandle" /> -->
<!-- <meta name="twitter:creator" content="@yourtwitterhandle" /> -->