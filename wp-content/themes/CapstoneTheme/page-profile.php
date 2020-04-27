 <!-- page-profile.php by Thais Vacaflores
Code for user profile that displays their major and registered events
-->

<?php
get_header();
?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/cayan.jpg')?>);">
  </div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php the_title()?></h1>
    <div class="page-banner__intro">
      <p><?php 
        $currentUser = wp_get_current_user();
        echo $current_user->user_login;?> 
      </p>
    </div>
  </div>  
</div>

<?php 
while(have_posts()){ 
  the_post(); 
?>
  <div class="container container--narrow page-section">
    <?php 
    if (is_user_logged_in()) { 

      //query to get all majors 
      $allMajors = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'major',
        'orderby' => 'title',
        'order' => 'ASC'
      ));
    ?>
      <h2 class="headline headline--small">Your Major</h2>
      <?php
      $theMajor = get_user_meta($currentUser->ID, 'major', true)[0];

      while ($allMajors->have_posts()){
        $allMajors->the_post();
      ?>
        <span class="major-box" data-major="<?php echo get_the_id();?>" data-selected=<?php if ($theMajor == get_the_id()) {echo 'yes';} ?>><?php the_title();?></span>
      <?php
      }
      ?>
      <hr class= "section-break">
      <h2 class="headline headline--small">Your Registered Events</h2>
      <?php

      //query to filter the events
      $events = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'event',
        'meta_key' => 'event_start',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
      ));

      while($events -> have_posts()){    
        $events -> the_post();

        //query to get registered events
        $eventID = get_the_ID();
        $registerEvent = new WP_Query(array(
          'author' => get_current_user_id(),
          'post_type' => 'register',
          'meta_query' => array(
            array(
              'key' => 'event_id',
              'compare' => '=',
              'value' => $eventID))
        ));

      //Output all registered events 
      if($registerEvent -> found_posts){
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
          <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink()?>"><?php the_title();?></a></h5>
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
    } 
    wp_reset_postdata();
  }
  ?>
  </div>
<?php
}
get_footer();
?>

