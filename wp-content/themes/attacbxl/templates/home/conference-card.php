<div class="col s6">
  <div class="card">
    <?php if ( has_post_thumbnail() ) { ?>
      <div class="card-image waves-effect waves-block waves-light">
        <a href="<?php the_permalink(); ?>">
          <?php the_post_thumbnail('event-card-thumb'); ?>
        </a>
      </div>
    <?php }?>
    <div class="card-content">
      <span class="card-title activator grey-text text-darken-4">
        <?php the_title(); ?>
        <i class="mdi-navigation-more-vert right"></i>
      </span>
      <p>
        <a href="<?php the_permalink(); ?>">
          Voir la vidéo
        </a>
      </p>
    </div>
    <div class="card-reveal">
      <span class="card-title grey-text text-darken-4">Card Title <i class="mdi-navigation-close right"></i></span>
      <?php the_excerpt(); ?>
    </div>
  </div>
</div>
