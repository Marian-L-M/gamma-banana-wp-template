<h3>Related Pages</h3>
<?php
$page_id = get_the_ID();

$childArray = get_pages([
  "child_of" => $page_id,
]);
$parent_id = wp_get_post_parent_id(get_the_ID());
$parent_id ? ($findChildrenOf = $parent_id) : ($findChildrenOf = get_the_ID());

$list_settings = [
  "title_li" => null,
  "child_of" => $findChildrenOf,
  "sort_column" => "menu_order",
];
if ($parent_id || $childArray) {
  wp_list_pages($list_settings);
}


?>
