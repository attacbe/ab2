<ul>
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
  <li class='media'>
    <?php echo the_event_start_date(); ?>
    <a href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
    </a>
  </li>
  <?php } wp_reset_query(); ?>
</ul>
