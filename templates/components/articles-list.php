<div class="section articles-list">
  <?php
  global $post;
  $args = array(
    'posts_per_page'   => 5,
    'category_name'    => 'presse',
    'post_status'      => 'publish'
  );
  $posts_array = get_posts( $args );

  foreach($posts_array as $post) {
    setup_postdata($post);
  ?>
  <div class='media'>
    <div class="media-body">
      <?php the_date() ?>
      <a href="<?php the_permalink(); ?>" class='media-heading'>
        <h5><?php the_title(); ?></h5>
      </a>
    </div>
  </div>
  <?php } wp_reset_query(); ?>
</div>
