    <?php 
     function generateFeaturedPostHTML($id) {
        $allowedPostTypes = ['roadmap', 'projects', 'features', 'posts', 'guides', "wikis", "notes"];
        $featuredPosts = new WP_Query([
            "post_type" => $allowedPostTypes,
            "p" => $id,
        ]);

        while ($featuredPosts->have_posts()) {
            $featuredPosts->the_post();

            ob_start();
            ?>
    <div class="featured-callout fx-row">
        <?php $thumb_url = get_the_post_thumbnail_url(get_the_ID(), "mobile"); ?>
        <div class="featured-callout__image"
            style="background-image:url(<?php echo esc_url($thumb_url); ?>); display: block; width: 100px; height: 100px;">
        </div>
        <div class="featured-callout__text">
            <h5><?php echo esc_html(get_the_title()) ?></h5>
            <p><?php echo wp_trim_words(wp_strip_all_tags(get_the_content()), 30) ?></p>
            <?php 
                $relatedPosts = get_field("related_post");
                if($relatedPosts) {
                    ?>
            <?php foreach($relatedPosts as $key => $relatedPost): ?>
            <p>Related Title: <?php echo esc_html(get_the_title($relatedPost)); ?></p>
            <a href="<?php echo get_the_permalink($relatedPost); ?>">> Link</a>
            <?php
                endforeach;
                }
            ?>
        </div>
    </div>
    <?php
        wp_reset_postdata();
        return ob_get_clean();
            }
    }