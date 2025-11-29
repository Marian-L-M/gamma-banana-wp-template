  <?php
  $query_args = [
    "post_type" => "any",
    "post_status" => "publish",
    "posts_per_page" => 3,
    "order" => "DESC",
    "meta_query" => [
      [
        "key" => "related_post",
        "compare" => "LIKE",
        "value" => '"' . get_the_ID() . '"',
      ],
    ],
  ];
  // 251125 issue: query for ID not working, query logic itself is returning ID
  $query = new WP_Query($query_args);
  $related_posts = get_field("related_post");
  ?>

  <?php if ($related_posts || $query->have_posts()): ?>
  <div class="container container__full__pc related-items fx-col gap-2 mt-half" id="related-items">
      <h2>Related Items</h2>
      <!-- Directly related -->
      <?php if ($related_posts): ?>
      <div class="grid-container grid__24 gap-1">
          <?php foreach ($related_posts as $related_post):
            echo get_template_part("templates/post", "card", ["r_post" => $related_post]);
          endforeach; ?>
      </div>
      <?php endif; ?>
      <!-- Is related item of -->
      <?php if ($query->have_posts()): ?>
      <div class="grid-container grid__24 gap-1">
          <?php while ($query->have_posts()):
            $query->the_post();
            echo get_template_part("templates/post", "card");
          endwhile; ?>
      </div>
      <?php endif; ?>
  </div>
  <?php endif; ?>
