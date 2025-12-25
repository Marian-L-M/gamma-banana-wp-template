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
 * TEMPLATE_FOLDER/assets/img
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
        <source media="(min-width:1201px)" srcset="<?php echo "{$template_url}/assets/img/retina/{$file}"; ?>">
        <source media="(min-width:992px)"
            srcset="<?php echo "{$template_url}/assets/img/pc/{$file}"; ?> 1x, <?php echo "{$template_url}/assets/img/retina/{$file}"; ?> 2x">
        <source media="(min-width:576px)" srcset="<?php echo "{$template_url}/assets/img/tab/{$file}"; ?>">
        <img src="<?php echo "{$template_url}/assets/img/sp/{$file}"; ?>" alt="<?php echo $title; ?>">
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


/**
 * Generates full and outline heart icons. Full hearts before outlined.
 *
 * Default 1 heart #000
 *
 * @param int $number_full Number of full heart icons. Default 1.
 * @param int $number_outline Number of outline heart icons. Default 0.
 * @param string $color  Icon color. Default #000
 *
 * @return void
 */
function generate_hearts(  $number_full = 1 , $number_outline = 0, $color = "#000000") {
  ?>
<span class="heart-container">
    <?php 
        for ($i = 0; $i < $number_full; $i++): 
    ?>
    <svg class="heart heart-full" width="800px" height="800px" viewBox="0 0 16 16" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path
            d="M1.24264 8.24264L8 15L14.7574 8.24264C15.553 7.44699 16 6.36786 16 5.24264V5.05234C16 2.8143 14.1857 1 11.9477 1C10.7166 1 9.55233 1.55959 8.78331 2.52086L8 3.5L7.21669 2.52086C6.44767 1.55959 5.28338 1 4.05234 1C1.8143 1 0 2.8143 0 5.05234V5.24264C0 6.36786 0.44699 7.44699 1.24264 8.24264Z"
            fill="<?php echo $color ?>" />
    </svg>
    <?php 
        endfor;
        for ($i = 0; $i < $number_outline; $i++): 
        ?>
    <svg class="heart heart-outline" fill="<?php echo $color ?>" version="1.1" id="Capa_1"
        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px"
        viewBox="0 0 378.94 378.94" xml:space="preserve">
        <g>
            <path d="M348.151,54.514c-19.883-19.884-46.315-30.826-74.435-30.826c-28.124,0-54.559,10.942-74.449,30.826l-9.798,9.8l-9.798-9.8
            c-19.884-19.884-46.325-30.826-74.443-30.826c-28.117,0-54.56,10.942-74.442,30.826c-41.049,41.053-41.049,107.848,0,148.885
            l147.09,147.091c2.405,2.414,5.399,3.892,8.527,4.461c1.049,0.207,2.104,0.303,3.161,0.303c4.161,0,8.329-1.587,11.498-4.764
            l147.09-147.091C389.203,162.362,389.203,95.567,348.151,54.514z M325.155,180.404L189.47,316.091L53.782,180.404
            c-28.368-28.364-28.368-74.514,0-102.893c13.741-13.739,32.017-21.296,51.446-21.296c19.431,0,37.702,7.557,51.438,21.296
            l21.305,21.312c6.107,6.098,16.897,6.098,23.003,0l21.297-21.312c13.737-13.739,32.009-21.296,51.446-21.296
            c19.431,0,37.701,7.557,51.438,21.296C353.526,105.89,353.526,152.039,325.155,180.404z" />
        </g>
    </svg>
    <?php endfor; ?>
</span>
<?php
}