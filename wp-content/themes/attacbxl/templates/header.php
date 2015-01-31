<nav>
  <div class="container">
    <div class='nav-wrapper row'>
        <div class='col s12'>
          <a href='<?php echo esc_url(home_url('/')); ?>' class='brand-logo'><?php bloginfo('name'); ?></a>
          <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(array('theme_location' => 'primary_navigation', 'walker' => new Roots_Nav_Walker(), 'menu_class' => 'right side-nav'));
          endif;
          ?>

          <!-- Include this line below -->
          <a class='button-collapse' href='#' data-activates='menu-primary-navigation'><i class='mdi-navigation-menu'></i></a>
          <!-- End -->
        </div>
    </div>
  </div>
</nav>
