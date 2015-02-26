<?php
  global $post;
  $args = array(
    'posts_per_page'   => 5,
    'category_name'    => 'featured',
    'post_status'      => 'publish'
  );
  $posts_array = get_posts( $args );
?>

<?php if (count($posts_array) > 0): ?>
  <h3>
    <a href="<?php echo home_url(); ?>/articles" class='section-header'>
      Actions à la une
    </a>
  </h3>


  <?php
    foreach($posts_array as $post) {
      setup_postdata($post);
  ?>

    <div class='media media-featured'>
      <?php if ( has_post_thumbnail() ) { ?>
        <a href="<?php the_permalink(); ?>" class="media-left col-xs-6 centered-background" style="background-image: url(<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(), 'event-card-thumb' )[0]; ?>)"></a>
      <?php }?>
      <div class="media-body media-featured__body">
        <a href="<?php the_permalink(); ?>" class='media-heading'>
          <h3 class='media-featured__heading'><?php the_title(); ?></h3>
        </a>
        <?php the_excerpt(); ?>
      </div>
    </div>

  <?php } wp_reset_query(); ?>
<?php endif ?>
