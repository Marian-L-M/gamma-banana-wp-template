<?php 
function themeLikeRoutes(){
  register_rest_route("all/v1", "manageLikes", [
    "methods" => 'POST',
    "callback" => 'createLike',
  ]);
  register_rest_route("all/v1", "manageLikes", [
    "methods" => 'DELETE',
    "callback" => 'deleteLike',
  ]);
}

add_action('rest_api_init', "themeLikeRoutes");

function createLike($data) {
    if(is_user_logged_in()) {
        $postId = sanitize_text_field($data["likedPostId"]);
        $exist_like_query = new WP_Query([
            'author' => get_current_user_id(),
            'post_type' => "likes",
            'meta_query' => [
                [
                    'key' => 'liked_post_id',
                    'compare' => '=',
                    'value' => $postId
                ]
            ],
        ]) ;
                    
        if(!$exist_like_query -> found_posts && get_post_type($postId) == "projects") {
            return wp_insert_post([
                'post_type' => 'likes',
                'post_status' => 'publish',
                'post_title' => get_current_user_id() . "-to-". $postId,
                'meta_input' => [
                    'liked_post_id' => $postId,
                ],
            ]);
        } else {
            die("invalid ID");
        };

    } else {
        die("Only logged in users can like.");
    };

};
function deleteLike($data) {
    $postId = sanitize_text_field($data["likesId"]);
    if(get_current_user_id() == get_post_field('post_author', $postId) && get_post_type($postId) == "likes" ){
        wp_delete_post($postId, true);
        return "Like removed";
    } else {
        die("User authorization failed.");
    }
};