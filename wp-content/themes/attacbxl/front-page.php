<div class="masthead" style='background-image: url(<?php echo home_url(); ?>/assets/img/homebg.jpg);'>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <img src="<?php echo home_url(); ?>/assets/img/logo.png" alt="Attac Bruxelles 2: un autre monde est possible"/>
        <h1>Un autre monde est possible</h1>
        <h3>Réapproprions-nous ensemble l’avenir de notre société</h3>
      </div>
    </div>
  </div>
  <div class="masthead__mask" style='background-image: url(<?php echo home_url(); ?>/assets/img/homebg-mask.png);'>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-xs-8">
      <h3 class='section-header'>
        Dernières conférences
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

      <h3 class='section-header'>
        Presse / publications
      </h3>
      <?php get_template_part('templates/components/articles-list') ?>
    </div>
    <div class="col-xs-4">
      <h3 class='section-header'>
        Prochains évènements
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
