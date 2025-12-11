 <?php
 $post_object = $args["r_post"] ?? null;
 $thumbnail = get_the_post_thumbnail($post_object, $size = "medium");
 $post_type = get_post_type();
 ?>

 <div class="card card__post">
     <?php if($post_type == "roadmap"): ?>
     This is a roadmap item
     <?php endif; ?>
     <?php if($post_type == "projects"): ?>
     This is a project
     <?php endif; ?>
     <?php if($post_type == "features"): ?>
     This is a feature
     <?php endif; ?>
     <?php if($post_type == "guides"): ?>
     This is a guide
     <?php endif; ?>
     <?php if($post_type == "wikis"): ?>
     This is a wiki
     <?php endif; ?>
     <?php if($post_type == "post"): ?>
     This is a post
     <?php endif; ?>
     <?php if($post_type == "page"): ?>
     This is a page
     <?php endif; ?>
     <h5><?php echo get_the_title(); ?></h5>
     <p><?php echo get_the_excerpt(); ?></p>
     <a href="<?php echo get_the_permalink(); ?>" class="btn btn__rm btn__anim-bar"><span class="anim-inner">Read
             more</span></a>
 </div>