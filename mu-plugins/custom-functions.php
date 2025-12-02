<?php
// Source - https://stackoverflow.com/a
// Posted by Pieter Goosen
// Retrieved 2025-11-27, License - CC BY-SA 3.0

function generate_excerpt_with_link($limit)
{
  return wp_trim_words(
    get_the_excerpt(),
    $limit,
    '<a href="' . esc_url(get_permalink()) . '">' . "&nbsp;&hellip;" . __("Read more &nbsp;&raquo;") . "</a>",
  );
}

/**
 * Generate a responsive page banner with title overlay
 *
 * Requires the following template img file structure:
 * TEMPLATE_FOLDER/img
 * With subfolders sp/tab/pc/retina. Outputs a full-width banner from folders + inner path.
 *
 * @param string $file  The file name + inner path for an image
 * @param string $title The title text to display on the banner
 * @param string $subtitle The subtitle text to display on the banner (optional)
 *
 * @return void
 */
function generate_page_banner($file, $title, $subtitle = "")
{
  $template_url = get_template_directory_uri(); ?>
<div class="title-banner fx-content-center" id="title">
    <picture>
        <source media="(min-width:1201px)" srcset="<?php echo "{$template_url}/img/retina/{$file}"; ?>">
        <source media="(min-width:992px)"
            srcset="<?php echo "{$template_url}/img/pc/{$file}"; ?> 1x, <?php echo "{$template_url}/img/retina/{$file}"; ?> 2x">
        <source media="(min-width:576px)" srcset="<?php echo "{$template_url}/img/tab/{$file}"; ?>">
        <img src="<?php echo "{$template_url}/img/sp/{$file}"; ?>" alt="<?php echo $title; ?>">
    </picture>
    <h1 class="headline headline__large text-white">
        <?php echo $title; ?>
    </h1>
    <?php if ($subtitle): ?>
    <p><?php echo $subtitle; ?></p>
    <?php endif; ?>
</div>
<?php
}

/**
 * Generate a specified svg icon in a specific color
 *
 * Options: search
 *
 * @param string $name  The icon type
 * @param string $color The color to display the svg in
 *
 * @return void
 */
function generate_icon($name, $color = "#000000") {
  if($name == "search"):
  ?>
<!--  Search icon -->
<!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
<svg width="800px" height="800px" viewBox="0 -0.5 21 21" version="1.1" xmlns="http://www.w3.org/2000/svg"
    xmlns:xlink="http://www.w3.org/1999/xlink">

    <title>search_left [#1504]</title>
    <desc>Created with Sketch.</desc>
    <defs>

    </defs>
    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="Dribbble-Light-Preview" transform="translate(-299.000000, -280.000000)" fill="<?php echo $color; ?>">
            <g id="icons" transform="translate(56.000000, 160.000000)">
                <path
                    d="M264,138.586 L262.5153,140 L258.06015,135.758 L259.54485,134.343 L264,138.586 Z M251.4,134 C247.9266,134 245.1,131.309 245.1,128 C245.1,124.692 247.9266,122 251.4,122 C254.8734,122 257.7,124.692 257.7,128 C257.7,131.309 254.8734,134 251.4,134 L251.4,134 Z M251.4,120 C246.7611,120 243,123.582 243,128 C243,132.418 246.7611,136 251.4,136 C256.0389,136 259.8,132.418 259.8,128 C259.8,123.582 256.0389,120 251.4,120 L251.4,120 Z"
                    id="search_left-[#1504]">

                </path>
            </g>
        </g>
    </g>
</svg>
<?php
endif;
}