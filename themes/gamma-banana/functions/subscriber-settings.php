<?php 
// Subscriber functionality
function hideSubscriberAdminBar() {
    $currentUser = wp_get_current_user();

    if(count ($currentUser -> roles) == 1 && $currentUser->roles[0] == "subscriber") {
        show_admin_bar(false);
    }

}

add_action('wp_loaded', 'hideSubscriberAdminBar');
function redirectSubsToFrontend() {
    $currentUser = wp_get_current_user();

    if(count ($currentUser -> roles) == 1 && $currentUser->roles[0] == "subscriber") {
        wp_redirect(site_url('/'));
        exit;
    }

}

add_action('admin_init', 'redirectSubsToFrontend');