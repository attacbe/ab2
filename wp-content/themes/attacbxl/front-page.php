<div class="masthead" style='background-image: url(<?php echo home_url(); ?>/assets/img/homebg.jpg);'>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <img src="<?php echo home_url(); ?>/assets/img/logo.png" alt="Attac Bruxelles 2: un autre monde est possible"/>
        <h1>Un autre monde est possible</h1>
        <h2 class="text-muted"><small>Réapproprions-nous ensemble l’avenir de notre société</small></h2>
      </div>
    </div>
  </div>
  <div class="masthead__mask" style='background-image: url(<?php echo home_url(); ?>/assets/img/homebg-mask.png);'>
  </div>
</div>

<div class="row">
  <div class="container">
    <div class="col s9">
      <div class="row">
        <?php
          global $post;
          $all_events = tribe_get_events(array(
            'tribe_events_cat' => 'conferences',
            'order' => 'DESC',
            'eventDisplay'=>'past',
            'posts_per_page'=>-3
          ));

          foreach($all_events as $post) {
            setup_postdata($post);
        ?>
          <?php get_template_part('templates/home/conference-card') ?>
        <?php } wp_reset_query(); ?>
      </div>
    </div>
    <div class="col s3">
      <?php get_template_part('templates/home/upcoming-events') ?>
    </div>
  </div>
</div>
