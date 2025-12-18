<?php
get_header();
$page_id = get_the_ID();
$parent_id = wp_get_post_parent_id(get_the_ID());
$page_title = get_the_title();
?>
<main class="fx-col-center" id="page-main">
    <?php
    // Banner section
    echo get_template_part("templates/banner", "post", ["title" => $page_title]);
    // Breadcrumbs
    if ($parent_id): ?>
    <div class="container container__xl" id="breadcrumbs">
        <a href="<?php echo get_permalink($parent_id); ?>"><?php echo get_the_title($parent_id); ?></a>
        <span>
            <?php echo $page_title; ?>
        </span>
    </div>
    <?php endif;
    ?>
    <!-- Contents -->
    <div class="gap-1" id="layout-wrapper">
        <div class="col col__side col__left">
            <?php echo get_sidebar("secondary"); ?>
        </div>
        <div class="col col__center">
            <div class="container container__full__pc generic-contents" id="contents">
                <ul class="fx-col gap-1" id="user-notes">
                    <?php 
                    $args = [
                        "post_type" => "notes",
                        "posts_per_page" => -1,
                        "author" => get_current_user_id(),
                    ];
                    $userNotes = new WP_Query($args);

                    while($userNotes->have_posts()):
                        $userNotes->the_post();
                        $noteTitle = esc_attr(get_the_title());
                        $noteId= get_the_ID();
                    ?>
                    <li class="fx-col gap-r1" data-id="<?php echo $noteId ; ?>" data-title="<?php echo $noteTitle ; ?>">
                        <div class=" fx-row-between w100">
                            <input readonly value="<?php echo $noteTitle ?>" id="title-notes-<?php echo $noteId ; ?>"
                                class="title-notes">
                            <div class="button-container fx-row gap-2">
                                <button class="btn btn__edit">Edit</button>
                                <button class="btn btn__cancel">Cancel</button>
                                <button class="btn btn__delete">Delete</button>
                            </div>
                        </div>
                        <textarea readonly id="content-notes-<?php echo $noteId ; ?>"
                            class="content-notes"><?php echo esc_attr(wp_strip_all_tags(get_the_content()))?></textarea>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
        <div class="col col__side col__right">
            <?php echo get_sidebar("tertiary"); ?>
        </div>
    </div>
    </div>
</main>
<?php get_footer(); ?>