 <?php
 $post_object = $args["r_post"] ?? null;
 $thumbnail = get_the_post_thumbnail($post_object, $size = "medium");
 ?>

 <div class="card card__post">
     <?php if ($thumbnail): ?>
     <a href="<?php echo get_the_permalink($post_object); ?>" class="img-container">
         <?php echo $thumbnail; ?>
     </a>
     <?php endif; ?>
     <h5><?php echo get_the_title($post_object); ?></h5>
     <p><?php echo wp_trim_words(get_the_excerpt($post_object), 20, "..."); ?></p>
     <a href="<?php echo get_the_permalink($post_object); ?>" class="btn btn__rm btn__anim-bar"><span
             class="anim-inner">Read
             more</span></a>
 </div>