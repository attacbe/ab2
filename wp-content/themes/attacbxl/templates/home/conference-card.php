<div class="col-sm-6">
  <div class="thumbnail">
    <?php if ( has_post_thumbnail() ) { ?>
      <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail('event-card-thumb'); ?>
      </a>
    <?php }?>
    <div class="caption">
      <a href="<?php the_permalink(); ?>">
        <h5>
          <?php the_title(); ?>
        </h5>
      </a>
    </div>
  </div>
</div>
