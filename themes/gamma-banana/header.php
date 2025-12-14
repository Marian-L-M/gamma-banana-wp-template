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
        <ul class="fx-col">
            <?php if ( !is_user_logged_in() ): ?>
            <li>
                <a href="<?php echo esc_url(wp_registration_url()) ?>">Sign up</a>
            </li>
            <li>
                <a href="<?php echo esc_url(wp_login_url()) ?>">Log in</a>
            </li>
            <?php else: ?>
            <li>
                <a href="">
                    <!-- Profile -->
                    <?php echo get_avatar(get_current_user_id(), 60); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo esc_url(wp_logout_url()) ?>">Logout</a>
            </li>
            <?php endif ?>
        </ul>
    </nav>
</header>

<body <?php body_class(); ?>>