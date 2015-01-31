<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    </div>
  <![endif]-->

  <?php
  do_action('get_header');
  get_template_part('templates/header');
  ?>
  <?php if (is_front_page()): ?>
    <?php include roots_template_path(); ?>
  <?php else: ?>
    <div class="container" role="document">
      <div class="row">
        <?php if (roots_display_sidebar()) : ?>
          <main class="col s8" role="main">
            <?php include roots_template_path(); ?>
          </main>
          <aside class="sidebar col s4" role="complementary">
            <?php include roots_sidebar_path(); ?>
          </aside>
        <?php else: ?>
          <main class="col s12" role="main">
            <?php include roots_template_path(); ?>
          </main>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>


  <?php get_template_part('templates/footer'); ?>

  <?php wp_footer(); ?>

</body>
</html>
