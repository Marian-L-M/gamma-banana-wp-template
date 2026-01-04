<?php 

/*
Plugin Name: Ello Govna!
Description: Quantum spanner functionaliteis.
Version: 1.0
Author: Marian Maschke
Author URI: https://nama-tamago.dev
Text Domain: ellogvonadomain
Domain Path: /languages

*/

// function addToEndOfPost($content) {
//     if(is_single() && is_main_query()) {
//         return "{$content}<p>ello govna</p>";
//     };
    
//     return $content;
// }

// add_filter("the_content", "addToEndOfPost");

class WordCountAndTimePlugin  {
    function __construct() {
        add_action("admin_menu", [$this, 'customSettingsPage']);
        add_action("admin_init", [$this, 'settings']);
        add_filter("the_content", [$this , 'ifWrapCheckbox']);
        add_action("init", [$this, 'languages']);
    }

    function languages() {
        load_plugin_textdomain("ellogvonadomain", false, dirname(plugin_basename(__FILE__)) . "/languages");
    }
    
    function customSettingsPage() {
        add_options_page("Word Count Settings", __("Word Count", "ellogvonadomain"),"manage_options","word-count-settings-page",[$this,"setSettingsPageContent"]);
    }

    function ifWrapCheckbox($content) {
        if(
            is_main_query() 
            && is_single() 
            && (get_option("wcp_wordcount", "1") || get_option("wcp_charactercount", "1") || get_option("wcp_readtime" , "1"))
            ) {
                return $this->createHTML($content);
        }
        return $content;
    }
    
    function setSettingsPageContent() { ?>
<div class="wrap">
    <h1><?php echo __("Word Count Settings", "ellogvonadomain") ?></h1>
    <form action="options.php" method="POST">
        <?php
        settings_fields("wordcountplugin");
        do_settings_sections("word-count-settings-page");
        submit_button()
    ?>
    </form>
</div>
<?php
    }

    function settings() {
        add_settings_section("wcp_first_section", null,null, "word-count-settings-page");

        // Location
        add_settings_field("wcp_location", __("Display Location", "ellogvonadomain"), [$this, 'locationHTML'], "word-count-settings-page","wcp_first_section");
        register_setting("wordcountplugin", "wcp_location", ['sanitize_callback' => [$this, 'sanitizeLocation'], 'default' => '0']);

        // Headline
        add_settings_field("wcp_headline", __("Headline Text", "ellogvonadomain"), [$this, 'headlineHTML'], "word-count-settings-page","wcp_first_section");
        register_setting("wordcountplugin", "wcp_headline", ['sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics']);
        
        // Wordcount
        add_settings_field("wcp_wordcount", __("Word Count", "ellogvonadomain"), [$this, 'checkboxHTML'], "word-count-settings-page","wcp_first_section", ["theName" => "wcp_wordcount"]);
        register_setting("wordcountplugin", "wcp_wordcount", ['sanitize_callback' => 'sanitize_text_field', 'default' => '1']);
        
        // Character Count
        add_settings_field("wcp_charactercount", __("Character Count", "ellogvonadomain"), [$this, 'checkboxHTML'], "word-count-settings-page","wcp_first_section", ["theName" => "wcp_charactercount"]);
        register_setting("wordcountplugin", "wcp_charactercount", ['sanitize_callback' => 'sanitize_text_field', 'default' => '1']);
        
        // Read time
        add_settings_field("wcp_readtime", __("Read Time", "ellogvonadomain"), [$this, 'checkboxHTML'], "word-count-settings-page","wcp_first_section", ["theName" => "wcp_readtime"]);
        register_setting("wordcountplugin", "wcp_readtime", ['sanitize_callback' => 'sanitize_text_field', 'default' => '1']);
    }
    function sanitizeLocation($input) {
        if($input != 0 && $input != 1) {
            add_settings_error("wcp_location" , "wcp_location_error", "Display location must be beginning or end.");
            return get_option("wcp_location");
        } 
        return $input;
    }


    // Html generating functions
    function createHTML($content) {
        $html = '<h3>' . esc_html(get_option("wcp_headline", "Post Statistics")) . '</h3><p>';

        if(get_option("wcp_wordcount", "1") || get_option("wcp_readtime", "1") ) {
            $wordCount = str_word_count(strip_tags($content));
        }

        if(get_option("wcp_wordcount", "1") ){
            $html .= __("The post has", "ellogvonadomain") . " " . $wordCount . " " . __("words", "ellogvonadomain")  . ".<br>";
        }

        if(get_option("wcp_charactercount", "1") ){
            $html .= __("The post has", "ellogvonadomain") . " " . strlen(strip_tags($content)) . " " . __("characters", "ellogvonadomain")  . ".<br>";
        }

        if(get_option("wcp_readtime", "1") ){
            $html .= __("The post takes", "ellogvonadomain") . " " . round($wordCount / 225). " " . __("minute(s) to read", "ellogvonadomain")  . ".<br>";
        }
        
        $html .= "</p>";


        if(get_option("wcp_location", "0") == "0") {
            return $html . $content;
        }
        return $content . $html;
    }

    function locationHTML() { ?>
<select name="wcp_location">
    <option value="0" <?php selected(get_option("wcp_location"), 0); ?>>
        <?php echo esc_html__("Beginning of Post", "ellogvonadomain") ?></option>
    <option value="1" <?php selected(get_option("wcp_location"), 1); ?>>
        <?php echo esc_html__("End of Post", "ellogvonadomain") ?></option>
</select>
<?php }

    function headlineHTML() { ?>
<input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option('wcp_headline')); ?>">
<?php }

    function checkboxHTML($args) {?>
<input type="checkbox" name="<?php echo $args['theName'] ?>" value="1"
    <?php checked(get_option($args['theName'] , "1")) ?>>
<?php
    }

}
$WordCountAndTimePlugin=new WordCountAndTimePlugin();