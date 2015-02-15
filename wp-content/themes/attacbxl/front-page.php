<div class="masthead container-fluid" style='background-image: url(<?php echo home_url(); ?>/assets/img/homebg.jpg);'>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <img src="<?php echo home_url(); ?>/assets/img/logo.png" alt="Attac Bruxelles 2: un autre monde est possible"/ id="logo">
        <h1>Un autre monde est possible</h1>
        <h3>Réapproprions-nous ensemble l’avenir de notre société</h3>
      </div>
    </div>
  </div>
  <div class="masthead__mask hidden-xs" style='background-image: url(<?php echo home_url(); ?>/assets/img/homebg-mask.png);'></div>
  <div class="masthead__sign hidden-xs" style='background-image: url(<?php echo home_url(); ?>/assets/img/fist.png);'></div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-8">
      <h3>
        <a href="<?php echo home_url(); ?>/agenda/categorie/conferences/liste/?action=tribe_list&tribe_paged=1&tribe_event_display=past" class='section-header'>
          Dernières conférences
        </a>
      </h3>
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

      <div class="row">
        <div class="col-sm-6">
          <h3>
            <a href="<?php echo home_url(); ?>/articles" class='section-header'>
              Presse / publications
            </a>
          </h3>
          <?php get_template_part('templates/components/articles-list') ?>
        </div>
        <div class="col-sm-6">
          <?php $page = get_page_by_title('Alter sommet'); ?>
              <h3>
                <a href="<?php echo get_permalink($page->ID); ?>" class='section-header'>
                  <?php echo get_the_title($page->ID); ?>
                </a>
              </h3>
            <a href="<?php echo get_permalink($page->ID); ?>">
              <?php echo get_the_post_thumbnail( $page->ID, 'medium', array('class' => "spread thumbnail col-xs-12")); ?>
            </a>
          <?php echo wp_trim_words($page->post_content, $num_words = 50, $more = null );  ?>
          <p>
            <a href="<?php echo get_permalink($page->ID); ?>">
              En savoir plus
            </a>
          </p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <h3>
        <a href="<?php echo home_url(); ?>/events" class='section-header'>
          Prochains évènements
        </a>
      </h3>
      <?php get_template_part('templates/components/upcoming-events') ?>

      <div class="panel panel-grey">
        <div class="panel-heading">
          <h5>A propos d'Attac bruxelles 2</h5>
        </div>
        <div class="panel-body">
          <p>
            Attac est une asbl dont le double objectif est d'acquérir une connaissance critique de la mondialisation financière, et d'agir s'y opposer.
          </p>
          <div class="row section">
            <div class="col-sm-6">
              <a href="">
                <img src="<?php echo home_url(); ?>/assets/img/memorandom.jpg" alt="Memorandom 2014 attac" />
              </a>
              <div class="caption">
                <a href="">
                  <h5>
                    Memorandom Attac Wal-Bxl 2014
                  </h5>
                </a>
              </div>
            </div>
            <div class="col-sm-6">
              <a href="">
                <img src="<?php echo home_url(); ?>/assets/img/booklet-attac.jpg" alt="Leaflet Attac bruxelles 2" />
              </a>
              <div class="caption">
                <a href="">
                  <h5>
                    Leaflet Attac bruxelles 2
                  </h5>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
