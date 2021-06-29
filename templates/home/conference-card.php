<div class="col-xs-12 posts-list__item">
  <div class="row">
    <?php if (has_post_thumbnail()) { ?>
      <div class="col-sm-5">
        <a href="<?php the_permalink(); ?>" class='media-object thumbnail'>
          <?php the_post_thumbnail('event-card-thumb'); ?>
        </a>
      </div>
    <?php } ?>
    <div class="col-sm-7">
      <time class="updated" datetime="<?php echo get_the_time('c'); ?>">
        <?php echo get_the_date(); ?>
      </time>
      <a href="<?php the_permalink(); ?>">
        <h4 class='media-heading'>
          <?php the_title(); ?>
        </h4>
      </a>
      <?php the_excerpt(); ?>
    </div>
  </div>
</div>