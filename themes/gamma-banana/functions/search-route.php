<?php 
function themeRegisterAllCptSearch(){
  register_rest_route("all/v1", "search", [
    "methods" => WP_REST_SERVER::READABLE,
    "callback" => "allSearchResults",
  ]);
}

add_action('rest_api_init', "themeRegisterAllCptSearch");

function allSearchResults($data) {
  $entries = new WP_QUERY([
    "post_type" => 'any',
    "s" => sanitize_text_field( $data["keyword"])
  ]);

  // Order results
  $post_types = get_post_types(['public' => true]);
  $results = [];

    foreach($post_types as $post_type)  {
        $results[$post_type] = [];
    }

  function get_default_data() {
    $defaultData = [
                  'post_type' => get_post_type(),
                  'id' => get_the_id(),
                  'title' => get_the_title(),
                  'permalink' => get_the_permalink(),
                  'excerpt' => get_the_excerpt(),
                  'thumbnail' => (get_post_thumbnail_id() ? wp_get_attachment_image_src(get_post_thumbnail_id(),"medium") : ""),
    ];
    return $defaultData ;
  }
  
    while($entries->have_posts()) {
        $entries -> the_post();
        foreach($post_types as $post_type) {
            if(get_post_type() == $post_type) {
                array_push($results[$post_type],get_default_data() );
            }
        }
    }

    return $results;
}
function themeRegisterWikiSearch(){
    register_rest_route("wiki/v1", "search", [
        "methods" => WP_REST_SERVER::READABLE,
        "callback" => "wikiSearchResults",
    ]);
}

function wikiSearchResults() {
  $entries = new WP_QUERY([
    "post_type" => 'wiki',
  ]);

  return $entries->posts;
}