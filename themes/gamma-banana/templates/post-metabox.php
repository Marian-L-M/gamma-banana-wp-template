<div class="metabox container__full" id="metabox">
    <div class="metabox-links fx-row gap-1 fx-wrap">
        <?php if ($args["parent_id"] != 0): ?>
        <a href="<?php echo get_the_permalink($args["parent_id"]); ?>"
            class="metabox-item"><?php echo get_the_title($args["parent_id"]); ?></a>
        <?php endif; ?>
        <span class="metabox-item"><?php echo get_the_title(); ?></span>
    </div>
    <div class="metabox-contents fx-row gap-1 fx-wrap">
        <span class="metabox-item">By <?php echo get_the_author_posts_link(); ?></span>
        <span class="metabox-item">(<?php echo get_the_time("Y.m.d"); ?>)</span>
    </div>
    <div class="metabox-contents fx-col gap-1">
        <ul class="cats fx-row fx-wrap gap-1">
            <span>
                <?php echo get_the_category_list("</span><span>", ""); ?>
            </span>
        </ul>
        <ul class="tags fx-row fx-wrap gap-1">
            <?php echo get_the_tag_list("<span>", "</span><span>", "</span>"); ?>
        </ul>
    </div>
</div>
<hr>