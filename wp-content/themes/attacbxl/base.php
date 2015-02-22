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
          <main class="col-md-8" role="main">
            <?php include roots_template_path(); ?>
          </main>
          <aside class="sidebar col-md-4" role="complementary">
            <?php include roots_sidebar_path(); ?>
          </aside>
        <?php else: ?>
          <main class="col-xs-12 col-sm-8 col-sm-offset-2" role="main">
            <?php include roots_template_path(); ?>
          </main>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>


  <?php get_template_part('templates/footer'); ?>

  <?php wp_footer(); ?>


<!-- KISSmetrics tracking snippet -->
<script type="text/javascript">var _kmq = _kmq || [];
var _kmk = _kmk || '57a160cc300e64903d5137e9696209f6f45636b6';
function _kms(u){
  setTimeout(function(){
    var d = document, f = d.getElementsByTagName('script')[0],
    s = d.createElement('script');
    s.type = 'text/javascript'; s.async = true; s.src = u;
    f.parentNode.insertBefore(s, f);
  }, 1);
}
_kms('//i.kissmetrics.com/i.js');
_kms('//doug1izaerwt3.cloudfront.net/' + _kmk + '.1.js');
</script>
</body>
</html>
