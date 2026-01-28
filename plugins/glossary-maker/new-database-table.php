<?php

/*
  Plugin Name: Glossary Maker
  Version: 1.0
  Author: Marian Maschke
  Author URI: https://namatamagao.dev
  Description: Generate story glossaries
*/

// Fork from Brad Schiff's Become a Wordpress Developer course. Section 27/164
// https://www.udemy.com/user/bradschiff

if( ! defined( 'ABSPATH' ) ) exit; 
require_once plugin_dir_path(__FILE__) . 'inc/generateGlossaryEntry.php';

class GlossaryTablePlugin {
  public function __construct() {
    global $wpdb;
    $this->charset = $wpdb->get_charset_collate();
    $this->tablename = $wpdb->prefix . "glossary";

    add_action('activate_glossary-maker/new-database-table.php', [$this, 'onActivate']);
    // Change activation hook pattern
    // register_activation_hook(__FILE__, [$this, 'onActivate']);
    // add_action('admin_notices', [$this, 'populateFast']);
    // add_action('admin_head', [$this, 'onAdminRefresh']);
    add_action('wp_enqueue_scripts', array($this, 'loadAssets'));
    add_filter('template_include', [$this, 'loadTemplate'], 99);
  }

  public function onActivate() {
    require_once(ABSPATH . "wp-admin/includes/upgrade.php");
    dbDelta("CREATE TABLE $this->tablename (
      id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      birthyear smallint(6)  NOT NULL DEFAULT 0,
      score smallint(6)  NOT NULL DEFAULT 0,
      favfood varchar(60)  NOT NULL DEFAULT '',
      faction varchar(60)  NOT NULL DEFAULT '',
      profession varchar(60)  NOT NULL DEFAULT '',
      species varchar(60)  NOT NULL DEFAULT '',
      first_name varchar(60)  NOT NULL DEFAULT '',
      last_name varchar(60)  NOT NULL DEFAULT '',
      title_name varchar(60)  NOT NULL DEFAULT '',
      PRIMARY KEY  (id)
    ) $this->charset;");
  }

  public function onAdminRefresh() {
    // global $wpdb;
    // $wpdb->insert($this->tablename, generateGlossaryEntry());
  }

  function loadAssets() {
    if (is_page('glossary')) {
      wp_enqueue_style('glossary_styles', plugin_dir_url(__FILE__) . 'glossary.css');
    }
  }

  public function loadTemplate($template) {
    if (is_page('glossary')) {
      return plugin_dir_path(__FILE__) . 'inc/template-glossary.php';
    }
    return $template;
  }

  // Populate fast is not working. I suspect an order issue in the insertion arrays
  public function populateFast() {
    global $wpdb;

    // echo '<div class="notice notice-info"><p><strong>DEBUG:</strong> populateFast() is running... Table: ' . $this->tablename . '</p></div>';

    // // TEMPORARY: Clear table for testing
    // $wpdb->query("TRUNCATE TABLE $this->tablename");

    // // Only run once - check if table already has data
    // $count = $wpdb->get_var("SELECT COUNT(*) FROM $this->tablename");
    // echo '<div class="notice notice-info"><p><strong>DEBUG:</strong> Current row count: ' . $count . '</p></div>';

    // if ($count > 0) {
    //   echo '<div class="notice notice-warning"><p><strong>INFO:</strong> Table already has ' . $count . ' rows, skipping insert.</p></div>';
    //   return; // Already populated
    // }

    $query = "INSERT INTO $this->tablename (`species`, `birthyear`, `score`, `favfood`, `profession`, `faction`, `first_name`, `last_name`, `title_name`) VALUES ";
    $numberCharacters = 10000;
    for ($i = 0; $i < $numberCharacters; $i++) {
      $character = generateGlossaryEntry();
      // Escape all string values to prevent SQL injection and syntax errors
      $species = esc_sql($character['species']);
      $favfood = esc_sql($character['favfood']);
      $profession = esc_sql($character['profession']);
      $faction = esc_sql($character['faction']);
      $first_name = esc_sql($character['first_name']);
      $last_name = esc_sql($character['last_name']);
      $title_name = esc_sql($character['title_name']);

      $query .= "('$species', {$character['birthyear']}, {$character['score']}, '$favfood', '$profession', '$faction', '$first_name', '$last_name', '$title_name')";
      if ($i != $numberCharacters - 1) {
        $query .= ", ";
      }
    }
    /*
    Never use query directly like this without using $wpdb->prepare in the
    real world. I'm only using it this way here because the values I'm
    inserting are coming fromy my innocent pet generator function so I
    know they are not malicious, and I simply want this example script
    to execute as quickly as possible and not use too much memory.
    */
    // Should use $wpdb->prepare() or at least esc_sql() for each value.
    $result = $wpdb->query($query);

    // // Debug output
    // if ($result === false) {
    //   echo '<div class="notice notice-error"><p>';
    //   echo '<strong>SQL Error:</strong> ' . $wpdb->last_error . '<br>';
    //   echo '<strong>Query (first 500 chars):</strong> ' . htmlspecialchars(substr($query, 0, 500));
    //   echo '</p></div>';
    // } else {
    //   echo '<div class="notice notice-success"><p><strong>SUCCESS:</strong> Inserted ' . $result . ' rows!</p></div>';
    // }
  }

}

$glossaryTablePlugin = new GlossaryTablePlugin();