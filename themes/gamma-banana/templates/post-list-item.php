 <?php
 $event_date = get_field("event_date") ? new DateTime(get_field("event_date")) : "";
 $display_time = $event_date ? $event_date->format("d-m-Y") : get_the_time("Y.m.d");
 ?>

 <div class="post-list-item">
     <div class="meta-box">
         <h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
         <p>By <?php echo get_the_author_posts_link(); ?> (<?php echo $display_time; ?>)</p>
         <ul class="cats fx-row fx-wrap gap-1">
             <?php
             $cats = get_the_category($post->ID);
             foreach ($cats as $cat): ?>
             <li><?php echo $cat->name; ?></li>
             <?php endforeach;
             ?>
         </ul>
     </div>
     <p class="excerpt">
         <?php echo get_the_excerpt(); ?>
     </p>
     <a href="<?php echo get_the_permalink(); ?>" class="btn btn__rm btn__anim-bar"><span class="anim-inner">Read
             more</span></a>
 </div>