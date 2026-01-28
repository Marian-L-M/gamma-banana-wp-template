<?php
if (!defined("ABSPATH")) {
  exit();
}

class getGlossary
{
  public function __construct()
  {
    global $wpdb;
    // $queryContents = $wpdb->prepare("SELECT * from wp_glossary WHERE profession = %s AND birthyear > %d LIMIT 100", [
    //   "Merchant",
    //   9000,
    // ]);
    $tablename = $wpdb->prefix . "glossary";
    $queryContents = $wpdb->prepare("SELECT * FROM $tablename LIMIT 100");
    $this->glossary = $wpdb->get_results($queryContents);

    // echo "<pre>";
    // var_dump($glossary);
    // echo "</pre>";
  }
}
