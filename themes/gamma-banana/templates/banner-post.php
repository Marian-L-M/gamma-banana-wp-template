    <?php
    $page_title = $args["title"] ?? get_the_title();
    $page_subtitle = get_field("subtitle");
    $attachment_id = get_post_thumbnail_id();
    $banner = get_field("banner");
    $sizes = ["mobile", "banner", "banner-xl"];

    $image_mobile = wp_get_attachment_image_src($attachment_id, $sizes[0]);
    $image_spc = wp_get_attachment_image_src($attachment_id, $sizes[1]);
    $image_lpc = wp_get_attachment_image_src($attachment_id, $sizes[2]);

    // Banner via banner field
    if (isset($banner)): ?>
    <div class="title-banner fx-content-center gap-1 mt-half" id="title">
        <picture>
            <source media="(min-width:650px)" srcset="<?php echo $banner["sizes"]["banner-xl"]; ?>">
            <source media="(min-width:465px)" srcset="<?php echo $banner["sizes"]["banner"]; ?>">
            <img src="<?php echo $banner["sizes"]["mobile"]; ?>" alt="<?php echo $page_title; ?>">
        </picture>
        <h1>
            <?php echo $page_title; ?>
        </h1>
        <?php if ($page_subtitle): ?>
        <p><?php echo $page_subtitle; ?></p>
        <?php endif; ?>
    </div>
    <?php
      // Banner via thumbnail

      elseif (!empty($attachment_id)): ?>
    <div class="title-banner fx-content-center gap-1 mt-half" id="title">
        <picture>
            <source media="(min-width:650px)" srcset="<?php echo $image_lpc[0]; ?>">
            <source media="(min-width:465px)" srcset="<?php echo $image_spc[0]; ?>">
            <img src="<?php echo $image_mobile[0]; ?>" alt="<?php echo $page_title; ?>">
        </picture>
        <h1>
            <?php echo $page_title; ?>
        </h1>
        <?php if ($page_subtitle): ?>
        <p><?php echo $page_subtitle; ?></p>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="title-text-only fx-col-center mt-st mb-half" id="title">
        <h1>
            <?php echo $page_title; ?>
        </h1>
    </div>
    <?php endif;

?>
