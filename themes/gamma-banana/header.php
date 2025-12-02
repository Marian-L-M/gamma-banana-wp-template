<?php $siteName = get_bloginfo("name"); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo get_template_part("partials/header", "ogp"); ?>
    <?php wp_head(); ?>
</head>
<header>
    <a href="<?php echo site_url(); ?>" class="logo">Logo</a>
    <nav>
        <?php wp_nav_menu([
          "theme_location" => "headerMenuLocation",
        ]); ?>
        <?php echo get_template_part("partials/button", "toggle-search"); ?>
    </nav>
</header>

<body <?php body_class(); ?>>