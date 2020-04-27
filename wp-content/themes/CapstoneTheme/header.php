<!-- header.php by Thais Vacaflores 
Code for the header of the whole site  
-->

<!DOCTYPE html>

<html <?php language_attributes();?>>
<head>

  <meta charSet="<?php bloginfo('charset') ?>">
  <meta name= "viewport" content = "width = device-width, initial-scale = 1">

  <title><?php wp_title(); ?></title>
  <?php wp_head();?> 

</head>

<body <?php body_class();?>>

<header class="site-header">
  <div class="container">
    <h1 class="logo-text float-left"><a href="<?php echo site_url()?>"><strong>Line</strong>Up</a></h1>
    <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
    <div class="site-header__menu group">
      <nav class="main-navigation">
        <?php
          wp_nav_menu(array(
            'theme_location' => 'headerMenu'
          ));
        ?>
      </nav>
      <div class="site-header__util">
        <?php 
        if(is_user_logged_in()){ 
        ?>
          <a href= "<?php echo wp_logout_url();?>" class="btn btn--small btn--light-blue float-left push-right btn--with-photo">
            <span class = "site-header__avatar"><?php echo get_avatar(get_current_user_id(), 60);?>
            </span>
            <span class = btn__text>Log Out
            </span>
          </a>
        <?php
        }
        else{ 
        ?>
          <a href="<?php echo wp_login_url();?>" class="btn btn--small btn--light-blue float-left push-right">Login</a>
          <a href="<?php echo wp_registration_url();?>" class="btn btn--small  btn--dark-blue float-left">Sign Up</a>
          <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i>
          </span>
        <?php 
        }
        ?>
      </div>
    </div>
  </div>
</header>