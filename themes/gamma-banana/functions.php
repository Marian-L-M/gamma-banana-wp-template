<?php
// Setup theme
// require get_theme_file_path("/functions/api-functions.php");
require get_theme_file_path("/functions/search-route.php");
require get_theme_file_path("/functions/login-settings.php");
require get_theme_file_path("/functions/subscriber-settings.php");
require get_theme_file_path("/functions/api-functions.php");

// Load CSS&JS
function load_project_files()
{
  // Register optional styles
  wp_register_style("samples", get_template_directory_uri() . "/css/samples.css");

  // Register & load theme required styles
  wp_enqueue_style("styles", get_stylesheet_uri());
  wp_enqueue_style("page_setup", get_template_directory_uri() . "/css/setup.css"); // CSS resets etc
  wp_enqueue_style("main_styles", get_template_directory_uri() . "/css/main.css"); // Structural css for template
  wp_enqueue_style("utilities", get_template_directory_uri() . "/css/utilities.css"); // utility css classes
  wp_enqueue_style("animation", get_template_directory_uri() . "/css/animation.css");

  // Load optional/specific styles
  wp_enqueue_style("samples"); // Sample styling, delete if you want to customize

  // Register Scripts
  // Load Scripts
  // Gamma banana theme setup
  wp_enqueue_script('gamma-banana-modules',get_theme_file_uri('/build/index.js') , array('jquery'), '1.0', true);
  wp_localize_script('gamma-banana-modules', 'gbThemeData', array(
    'root_url' => get_site_url(), // Make root url accessible to JS
    'nonce' => wp_create_nonce('wp_rest')
  ));
}
add_action("wp_enqueue_scripts", "load_project_files");

// Theme custom features
function theme_features()
{
  add_theme_support("title-tag");
  add_theme_support("post-thumbnails");
  add_image_size("mobile", 600, 900, true);
  add_image_size("banner", 1600, 600, true);
  add_image_size("banner-xl", 2400, 900, true);
  register_nav_menu("headerMenuLocation", "Header Menu Location");
  register_nav_menu("footerMenuLocation", "Footer Menu Location");
}

add_action("after_setup_theme", "theme_features");

// Theme archive settings
function filter_pre_get_posts($query)
{
  if (!is_admin() && is_post_type_archive("features") && $query->is_main_query()) {
    $query->set("orderby", "title");
    $query->set("order", "ASC");
    $query->set("posts_per_page", -1);
  }
  if (!is_admin() && is_post_type_archive("guides") && $query->is_main_query()) {
    $query->set("orderby", "title");
    $query->set("order", "ASC");
    $query->set("posts_per_page", -1);
  }
  if (!is_admin() && is_post_type_archive("roadmap") && $query->is_main_query()) {
    $today = date("Ymd");
    $query->set("posts_per_page", 10);
    $query->set("order", "DESC");
    $query->set("orderby", "meta_value_num");
    $query->set("meta_key", "event_date");
  }
}
add_action("pre_get_posts", "filter_pre_get_posts");