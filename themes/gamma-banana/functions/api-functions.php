<?php
// REST API TEMPLATE
function theme_custom_rest_global() {
$post_types = get_post_types();

// register_global_api_field($post_types, "FIELD_NAME_HERE", "DISPLAY_VALUE");
}

/**
* Register an API field value for a provided array of post_types
*
* @param array $post_types
* @param string $fieldName
* @param mixed $fieldValue
*
* @return void
*/
function register_global_api_field($post_types, $fieldName, $fieldValue) {
    foreach( $post_types as $type) {
        register_rest_field($type, $fieldName, array(
            'get_callback' => function() use ($fieldValue) {return $fieldValue;}
        ));
    }
}

add_action('rest_api_init', "theme_custom_rest_global");

// Endpoint security
// Server side policy

// REST API validation for notes
function validate_note_creation($prepared_post, $request) {
    if($prepared_post->post_type == 'notes') {
        if(count_user_posts(get_current_user_id(), "notes") > 4) {
            return new WP_Error(
                'note_limit_reached',
                'You have reached your note limit',
                ['status' => 403]
            );
        }
    }
    return $prepared_post;
}

add_filter('rest_pre_insert_notes', 'validate_note_creation', 10, 2);

// Force note post type to be private and sanitize
function handle_note_post_type($data, $postarr) {
    if($data['post_type'] == 'notes') {
        // sanitzie post usbmissions
        $data['post_title'] = wp_strip_all_tags($data['post_title']);
        $data['post_content'] = sanitize_textarea_field($data['post_content']);

        // Force private status
        if($data['post_status'] != 'trash') {
            $data['post_status'] = "private";
        }
    }
    return $data;
}

add_filter('wp_insert_post_data','handle_note_post_type', 10, 2);