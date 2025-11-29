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
