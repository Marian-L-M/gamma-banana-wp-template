<?php 

// Customize Login Screen
function siteHeaderUrl() {
    return(esc_url(site_url("/")));
};

add_filter("login_headerurl", "siteHeaderUrl");

function loginPageStyles() {
    wp_enqueue_style("system_styles", get_template_directory_uri() . "/css/system.css");

};

add_action("login_enqueue_scripts",  "loginPageStyles");

function loginTitle() {
    return get_bloginfo('name');
}

add_filter("login_headertitle", "loginTitle");