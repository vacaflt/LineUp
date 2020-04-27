<!-- footer.php by Thais Vacaflores
Code for the footer for whole website
-->

<footer class="site-footer">
  <div class="site-footer__inner container container--narrow">
    <div class="group">
      <div class="site-footer__col-one">
        <h1 class="logo-text logo-text--alt-color"><a href="<?php echo site_url()?>"><strong>Line</strong>Up</a></h1>
        <p><a class="site-footer__link" href="#">123.456.7890</a></p>
      </div>

      <div class="site-footer__col-two-three-group">
        <div class="site-footer__col-two">
          <h3 class="headline headline--small">Explore</h3>
          <nav class="nav-list">
            <?php
            wp_nav_menu(array(
              'theme_location' => 'footerMenu1'
            ));
            ?>  
          </nav>
        </div>

        <div class="site-footer__col-three">
          <h3 class="headline headline--small">Learn</h3>
          <nav class="nav-list">
              <?php
              wp_nav_menu(array(
                'theme_location' => 'footerMenu2'
              ));
              ?>
          </nav>
        </div>
      </div>

      <div class="site-footer__col-four">
        <h3 class="headline headline--small">Connect With Us</h3>
        <nav>
          <ul class="min-list social-icons-list group">
            <li><a href="#" class="social-color-facebook"><i class="fab fa-facebook fa-1.5x" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-twitter"><i class="fab fa-twitter fa-1.5x" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-youtube"><i class="fab fa-youtube fa-1.5x" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-linkedin"><i class="fab fa-linkedin fa-1.5x" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-instagram"><i class="fab fa-instagram fa-1.5x" aria-hidden="true"></i></a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</footer>



<?php 
wp_footer(); 
?>

</body>
</html>