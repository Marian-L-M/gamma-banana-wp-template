<?php 

/*
Plugin Name: Word Filter
Description: It filters and replaces words
Version: 1.0
Author: Marian Maschke
Author URI: https://nama-tamago.dev
Text Domain: wordfilterdomain
Domain Path: /languages

*/  

if(!defined('ABSPATH')) exit;

class WordFilterPlugin {
    function __construct() {
        add_action('admin_menu', [$this, 'menuSettings']);
        add_action('admin_init', [$this, 'optionsSettings']);
        if(get_option("plugin_words_to_filter")) add_filter('the_content', [$this, 'filterLogic']);
    }

    function filterLogic($content) {
        $restrictedWords = explode(',', get_option("plugin_words_to_filter"));
        $restrictedWordsTrimmed = array_map('trim', $restrictedWords);
        return  str_ireplace($restrictedWordsTrimmed, esc_html(get_option("replacementText", "abc")), $content);
    }

    function menuSettings() {
        // add_menu_page("Words to filter", "Word Filter","manage_options","wordfilter",[$this, 'wordfilterPage'],'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZD0iTTIxLDE2VjE0TDEzLDlWMy41QzEzLDIuNjcgMTIuMzMsMiAxMS41LDJDMTAuNjcsMiAxMCwyLjY3IDEwLDMuNVY5TDIsMTRWMTZMMTAsMTMuNVYxOUw4LDIwLjVWMjJMMTEuNSwyMUwxNSwyMlYyMC41TDEzLDE5VjEzLjVMMjEsMTZaIiAvPjwvc3ZnPg==', 100);
        $mainPageHook = add_menu_page("Words to filter", "Word Filter","manage_options","wordfilter",[$this, 'wordfilterPage'], plugin_dir_url(__FILE__) . 'data/images/airplane.svg', 100);
        add_submenu_page("wordfilter","Words to filter","Words List","manage_options", "wordfilter", [$this, "wordfilterPage"]);
        // Hackey solution to have the first menu item label overwrite the general plugin name
        add_submenu_page("wordfilter","Word Filter Options","Options","manage_options", "word-filter-options", [$this, "optionsSubPage"]);
        add_action("load-{$mainPageHook}", [$this, 'mainPageAssets']);
    }
    function optionsSettings() {
        add_settings_section("replacement-text-section", null, null, "word-filter-options");
        register_setting("replacementFields", "replacementText");
        add_settings_field("replacement-text","Filtered Text", [$this, "replacementFieldHTML"], "word-filter-options", "replacement-text-section");
    }


    function replacementFieldHTML() {
        ?>
<input type="text" name="replacementText" value="<?php echo esc_attr(get_option("replacementText", "***")); ?>">
<p class="description">Leave blank to remove filter replacement word.</p>
<?php
    }

    function mainPageAssets() {
        wp_enqueue_style("filterAdminCss", plugin_dir_url(__FILE__) . 'data/css/styles.css');
    }

    function handleForm() {
        if(isset($_POST["filterWordNonce"]) && wp_verify_nonce($_POST["filterWordNonce"], 'saveFilterWords') && current_user_can("manage_options")) {
        if (isset($_POST['plugin_words_to_filter'])) {
            update_option("plugin_words_to_filter", sanitize_textarea_field($_POST['plugin_words_to_filter']));
        }
    ?>
<div class="updated">
    <p>Filter wordes were saved</p>
</div>
<?php
} else { ?>
<div class="error">
    <p>Sorry, you don't have sufficient permissions to perform this action.</p>
</div>
<?php
}
}

function wordfilterPage() {?>
<div class="wrap">
    <h1>Word Filter</h1>
    <?php if(isset($_POST['justsubmitted']) == "true") $this->handleForm(); ?>
    <form method="POST">
        <input type="hidden" name="justsubmitted" value="true">
        <?php wp_nonce_field('saveFilterWords', "filterWordNonce") ?>
        <label for="plugin_words_to_filter">
            <p>Enter a <strong>comma-separated</strong> List of words to filter</p>
            <div class="word-filter__flex-container">
                <textarea name="plugin_words_to_filter" id="plugin_words_to_filter"
                    placeholder="bad, mean, awful, sausage"><?php echo esc_html(get_option("plugin_words_to_filter")) ?></textarea>
            </div>
        </label>
        <input type="submit" value="submit" id="submit" class="button button-primary" value="Save changes">
    </form>
</div>
<?php
    }



    function optionsSubPage() {?>
<div class="wrap">
    <h1>Word Filter Options</h1>

    <form action="options.php" method="POST">
        <?php 
            settings_errors();
            settings_fields("replacementFields");
            do_settings_sections("word-filter-options");
            submit_button();
         ?>
    </form>
</div>
<?php
    }
}

$WordFilterPlugin = new WordFilterPlugin();