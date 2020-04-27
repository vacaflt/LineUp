<!-- frontpage.php by Thais Vacaflores
Code for the front page of the site  
-->

<?php 
get_header();
?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/SUNYIT_field_house.jpg')?>);">
  </div>
  <div class="page-banner__content container t-center c-white">
    <h1 class="headline headline--large">Welcome!</h1>
    <h2 class="headline headline--medium">Get Started With Your Schedule</h2>
    <?php
    if (is_user_logged_in()){
    ?>
      <a href="<?php echo get_permalink(1196); ?>" class="btn btn--large btn--blue">My Schedule</a>
    <?php
    }
    else{
    ?>
      <a href="<?php echo wp_login_url();?>" class="btn btn--med btn--blue">Login</a>
      <a href="<?php echo wp_registration_url();?>" class="btn btn--med  btn--blue">Sign Up</a>
    <?php
    }
    ?>
  </div>
</div>


<div class="full-width-split group">
  <!--Events -->
  <div class="full-width-split__one">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
      <?php
      //query to filter the 2 most recents upcoming events
      $today = date('Ymd');
      $homeEvents = new WP_Query(array(
        'posts_per_page' => 2,
        'post_type' => 'event',
        'meta_key' => 'event_start',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
          array(
            'key' => 'event_start',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric'))
      ));

      //outputs the events and their dates
      while($homeEvents -> have_posts()){
        $homeEvents -> the_post(); 
      ?>
        <div class="event-summary">
          <a class="event-summary__date t-center" href="<?php the_permalink();?>">
            <span class="event-summary__month"><?php 
              $eventDate = new DateTime(get_field('event_start'));
              echo $eventDate -> format('M');?>
            </span>
            <span class="event-summary__day"><?php echo $eventDate -> format('d');?>
            </span>
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
            <p>
              <?php 
              if(has_excerpt()){
                echo get_the_excerpt();
              }
              else{
                echo wp_trim_words(get_the_content(), 25);
              }
              ?>
              <a href="<?php the_permalink();?>" class="nu gray">Read more</a>
            </p>
          </div>
        </div>  
      <?php 
      } 
      wp_reset_postdata();
      ?>  
      <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn btn--blue">View All Events</a></p>
    </div>
  </div>

  <!--Announcements -->
  <div class="full-width-split__two">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Announcements</h2>
      <?php

      //query to filter the 2 latest announcements
      $homePosts = new WP_Query(array(
        'posts_per_page' => 2
      ));

      //outputs the latest announcements and their posted dates
      while($homePosts-> have_posts()){
        $homePosts-> the_post(); 
      ?>  
        <div class="event-summary">
          <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink();?>">
            <span class="event-summary__month"><?php the_time('M');?>
            </span>
            <span class="event-summary__day"><?php the_time('d');?>
            </span>  
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
            <p>
              <?php 
              if(has_excerpt()){
                echo get_the_excerpt();
              }
              else{
                echo wp_trim_words(get_the_content(), 25);
              }
              ?> 
              <a href="<?php the_permalink();?>" class="nu gray">Read more</a>
            </p>
          </div>
        </div>  
      <?php 
      } 
      wp_reset_postdata();
      ?>
      <p class="t-center no-margin"><a href="<?php echo site_url('/blog');?>" class="btn btn--yellow">View All Announcements</a></p>
    </div>
  </div>
</div>

<!-- Slide Show in front page  -->
<div class="slider">
  <div class="slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/resdefault.jpg')?>);">
    <div class="slider__interior container">
      <div class="slider__overlay">
        <h2 class="headline headline--medium t-center">Orientation 2020</h2>
        <p class="t-center"></p>
        <p class="t-center no-margin"><a href="<?php echo site_url('/orientation-2020')?>" class="btn btn--blue">Check it out</a></p>
      </div>
    </div>
  </div>
  <div class="slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/inside.jpg')?>);">
    <div class="slider__interior container">
      <div class="slider__overlay">
        <h2 class="headline headline--medium t-center">Open House Fall 2020</h2>
        <p class="t-center"></p>
        <p class="t-center no-margin"><a href="<?php echo site_url('/open-house-fall-2020')?>" class="btn btn--blue">Check it out</a></p>
      </div>
    </div>
  </div>

  <div class="slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/cayan.jpg')?>);">
    <div class="slider__interior container">
      <div class="slider__overlay">
        <h2 class="headline headline--medium t-center">FIRST Robotics Competition</h2>
        <p class="t-center"></p>
        <p class="t-center no-margin"><a href="<?php echo site_url('/first-robotics-competition')?>" class="btn btn--blue">Check it out</a></p>
      </div>
    </div>
  </div>
</div>

<?php

get_footer();

?>