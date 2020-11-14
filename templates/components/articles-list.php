<div class="section articles-list">
  <?php
  global $post;
  $args = array(
    'posts_per_page'   => 3,
    'category_name'    => 'presse',
    'post_status'      => 'publish'
  );
  $posts_array = get_posts($args);

  foreach ($posts_array as $post) {
    setup_postdata($post);
  ?>
    <?php get_template_part('templates/home/conference-card') ?>
  <?php }
  wp_reset_query(); ?>
</div>