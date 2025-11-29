<?php
// Custom post types
// https://developer.wordpress.org/reference/functions/register_post_type/

// Roadmap Post Type
function theme_custom_post_types()
{
  // Roadmap and milestones
  register_post_type("roadmap", [
    "supports" => ["title", "editor", "excerpt", "thumbnail"],
    "rewrite" => [
      "slug" => "roadmap",
    ],
    "has_archive" => true,
    "public" => true,
    "show_in_rest" => true,
    "labels" => [
      "name" => "Roadmap",
      "add_new_item" => "Add new milestone",
      "edit_item" => "Edit milestone",
      "all_items" => "Milestones",
      "singular_name" => "Milestone",
    ],
    "menu_icon" => "dashicons-location-alt",
  ]);
  // Projects
  register_post_type("projects", [
    "supports" => ["title", "editor", "excerpt", "thumbnail"],
    "rewrite" => [
      "slug" => "projects",
    ],
    "has_archive" => true,
    "public" => true,
    "show_in_rest" => true,
    "labels" => [
      "name" => "Projects",
      "add_new_item" => "Add new project",
      "edit_item" => "Edit project",
      "all_items" => "Projects",
      "singular_name" => "project",
    ],
    "menu_icon" => "dashicons-networking",
  ]);
  // Project features
  register_post_type("features", [
    "supports" => ["title", "editor", "excerpt", "thumbnail"],
    "rewrite" => [
      "slug" => "features",
    ],
    "has_archive" => true,
    "public" => true,
    "show_in_rest" => true,
    "labels" => [
      "name" => "Features",
      "add_new_item" => "Add new feature",
      "edit_item" => "Edit feature",
      "all_items" => "Features",
      "singular_name" => "Feature",
    ],
    "menu_icon" => "dashicons-star-filled",
  ]);
  // Project guides
  register_post_type("guides", [
    "supports" => ["title", "editor", "excerpt", "thumbnail"],
    "rewrite" => [
      "slug" => "guides",
    ],
    "has_archive" => true,
    "public" => true,
    "show_in_rest" => true,
    "labels" => [
      "name" => "Guides",
      "add_new_item" => "Add new guide",
      "edit_item" => "Edit guide",
      "all_items" => "Guides",
      "singular_name" => "Guide",
    ],
    "menu_icon" => "dashicons-welcome-learn-more",
  ]);
}
add_action("init", "theme_custom_post_types");
