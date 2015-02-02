<div class="section upcoming-events">
  <?php
  global $post;
  $all_events = tribe_get_events(array(
    // 'tribe_events_cat' => 'conferences',
    'order' => 'ASC',
    'eventDisplay'=>'list',
    'posts_per_page'=>-3
  ));

  foreach($all_events as $post) {
    setup_postdata($post);
  ?>
  <div class='media'>
    <?php if ( has_post_thumbnail() ) { ?>
      <div class="media-left media-middle">
        <a href="<?php the_permalink(); ?>">
          <?php the_post_thumbnail('thumbnail'); ?>
        </a>
      </div>
    <?php }?>
    <div class="media-body">
      <?php echo the_event_start_date(); ?>
      <a href="<?php the_permalink(); ?>" class='media-heading'>
        <h5><?php the_title(); ?></h5>
      </a>
    </div>
  </div>
  <?php } wp_reset_query(); ?>
</div>
